<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function createOrder(array $attributes): array
    {
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

            foreach ($attributes["order"] as $item) {
                $order->orderItems()->create([
                    'product_id' => $item["product_id"],
                    'item_count' => $item["count"],
                    'price_at_order' => Product::find($item["product_id"])->price,
                ]);
            }

            // todo: fire new order job
            logger("ORDER::New customer order created with id: {$order->id} with {$order->orderItems->count()} items");

            return [$order, true, null];
            
        } catch (Throwable $e) {
            // clear the cart_id to allow retry
            request()->session()->forget("latest_cart_id");

            if (boolval($orderCreated)) {
                // rollback this order
                Order::find($orderCreated)->destroy();
            }

            logger($e->__toString());

            return [null, false, $e];
        }
    }
}
