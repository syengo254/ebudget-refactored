<?php

declare(strict_types=1);

namespace App\Http\Controllers\Stores;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StoreController extends Controller
{
    private function authCheck(Store $store)
    {
        Gate::define("summary", function (User $user, Store $store) {
            return $user->has_store && $user->is($store->user);
        });

        if (Gate::denies("summary", $store)) {
            return abort(403, 'Unauthorised access');
        }
    }

    public function index(Request $request, Store $store, int $page = 1, int $limit = 10)
    {
        $this->authCheck($store);

        return $store->products()->paginate($limit);
    }

    public function summary(Store $store)
    {
        $this->authCheck($store);

        $products = Product::query()
            ->withCount('orderItems')
            ->with("orderItems")
            ->where("store_id", "=", $store->id)
            ->addSelect([
                "total_quantity_ordered" => OrderItem::whereColumn("product_id", 'products.id')
                    ->selectRaw("sum(item_count) as quantity")
            ])
            ->get();

        $returnedItems = Store::find($store->id)->orderItems()->whereHas("order", function ($query) {
            $query->where("status", OrderStatus::CANCELLED->value);
        })->get();

        $amountSold = $products->flatMap(function ($item, $key) {
            return $item->orderItems;
        })->reduce(function (int $acc, $curr) {
            return $acc + ($curr->item_count * $curr->price_at_order);
        }, 0);

        return [
            "counts" => [
                "total_products" => $products->count(),
                "sales_this_week" => $products->reduce(function (int $carry, $item) {
                    return $carry + ($item->total_quantity_ordered ?? 0);
                }, 0),
                "returned_products" => $returnedItems->count(),
                "sales_amount" => $amountSold,
            ]
        ];
    }

    public function showVendorOrders(Store $store)
    {
        $this->authCheck($store);

        $products = Store::find($store->id)
            ->orderItems()
            ->with("product", "order:id,status,expected_delivery_date")
            ->whereHas("order", function ($query) {
                $query->where("status", OrderStatus::NEW)
                ->orWhere("status", OrderStatus::PENDING);
            })
            ->get();

        return $products->toArray();
    }
}
