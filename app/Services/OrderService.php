<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\StockUpdateType;
use App\Http\DTOs\OrderDTO;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Support\OrderNumberGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService
{
    public function getUserOrders(User $user, int $page, int $limit)
    {
        return $user->orders()
            ->select('id', 'order_no', 'status', 'actual_delivery_date', 'expected_delivery_date')
            ->with('orderItems.product:id,name')
            ->addSelect([
                'total' => OrderItem::whereColumn('order_id', 'orders.id')
                    ->selectRaw('sum(item_count * price_at_order) as cost'),
            ])
            ->latest()
            ->paginate($limit);
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

    public function create(array $attributes): OrderDTO
    {
        DB::beginTransaction();

        try {
            $order = Auth::user()->orders()->create([
                'delivery_charge' => 350,
                'expected_delivery_date' => now()->addDays(random_int(1, 3))->toDateString(),
                'latest_delivery_date' => now()->addDays(random_int(3, 5))->toDateString(),
                'actual_delivery_date' => null,
                'address_id' => Auth::user()->profile->active_address_id,
                'order_no' => OrderNumberGenerator::getNextCode(Order::latest()->first()->order_no ?? 'A000000001'),
            ]);

            $productService = new ProductService;

            $productIds = collect($attributes['order'])->pluck('product_id');
            $products = $productService->getProductsById($productIds)->keyBy('id');

            foreach ($attributes['order'] as $item) {
                $product = $products[$item['product_id']];

                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'item_count' => $item['count'],
                    'price_at_order' => $product->price,
                ]);

                $productService->updateStockAmount($product, $item['count'], StockUpdateType::REMOVE);
            }

            logger("ORDER::New customer order created with id: {$order->id} with {$order->orderItems->count()} items");

            DB::commit();

            return new OrderDTO($order, true, null);
        } catch (Throwable $e) {
            DB::rollBack();
            logger($e->__toString());

            return new OrderDTO(null, false, $e);
        }
    }

    public function setOrderStatus(Order $order, OrderStatus $status)
    {
        $order->status = $status;
        $order->save();
    }

    public static function confirmNewOrders()
    {
        // only confirm new orders that are more than 12 hrs old.
        return Order::query()
            ->where('status', '=', OrderStatus::NEW)
            ->where('created_at', '<=', now()->subHours(intval(env('ORDER_CONFIRM_AGE', '12'))))
            ->update([
                'status' => OrderStatus::CONFIRMED,
            ]);
    }
}
