<?php

namespace App\Services;

use App\Http\DTOs\OrderDTO;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService {

    public function getUserOrders(User $user, int $page, int $limit)
    {
        return $user->orders()->with("order_items")->paginate($limit);
    }

    public function getAllOrders(int $page, int $limit)
    {
        //
    }

    public function find(int $id): Order
    {
        return Order::findOrFail($id);
    }

    // make this function return a DTO

    public function createOrder(array $attributes): OrderDTO
    {
        DB::beginTransaction();
        $orderCreated = 0;

        try {
            $order = Auth::user()->orders()->create([
                'delivery_charge' => 350,
                'expected_delivery_date' => now()->addDays(random_int(1, 3))->toDateString(),
                'latest_delivery_date' => now()->addDays(random_int(3, 5))->toDateString(),
                'actual_delivery_date' => NULL,
                'address_id' => Auth::user()->profile->active_address_id,
            ]);

            $orderCreated = $order->id;

            $productIds = collect($attributes['order'])->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
            foreach ($attributes['order'] as $item) {
                $product = $products[$item['product_id']];
                $order->orderItems()->create([
                    'product_id' => $item["product_id"],
                    'item_count' => $item["count"],
                    'price_at_order' => $product->price,
                ]);
            }

            logger("ORDER::New customer order created with id: {$order->id} with {$order->orderItems->count()} items");

            DB::commit();
            return new OrderDTO($order, true, null);

        } catch (Throwable $e) {
            DB::rollBack();
            // clear the cart_id to allow retry
            request()->session()->forget("latest_cart_id");

            if (boolval($orderCreated)) {
                // rollback this order
                Order::find($orderCreated)->destroy();
            }

            logger($e->__toString());

            return new OrderDTO(null, false, $e);
        }
    }
}
