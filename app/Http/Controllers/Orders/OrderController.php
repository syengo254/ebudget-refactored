<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{

    public function __construct(protected OrderService $orderService) {}

    public function index(Request $request, int $page = 1, int $limit = 15)
    {
        return $this->orderService->getUserOrders(Auth::user(), $page, $limit);
    }

    public function store(OrderRequest $request)
    {
        $validated = $request->validated();
        $cart_id = $validated["cart_id"];
        $cartInSession = request()->session()->get("latest_cart_id", false);

        if ($cartInSession && $cartInSession["cart_id"] == $cart_id) {
            return response()->json([
                "success" => true,
                "message" => "Your order has been created.",
                "order" => Order::find($cartInSession["order_id"]),
                "extra" => request()->session()->get("latest_cart_id", false),
            ]);
        }

        [$order, $success, $error] = $this->orderService->createOrder($validated);

        if ($success) {
            // save cart_id to session to avoid multiple requests
            request()->session()->put("latest_cart_id", [
                "cart_id" => $cart_id,
                "order_id" => $order->id,
            ]);

            return response()->json([
                "success" => $success,
                "message" => "Your order has been created.",
                "order" => $order,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => $error ? $error->getMessage() : "Failed to create your order.",
                "order" => null,
            ]);
        }
    }

    public function show(Order $order)
    {
        Gate::define("can-view", function (User $user, Order $order) {
            return $user->is($order->user);
        });

        if (Gate::denies("can-view", $order)) {
            return abort(403);
        }

        return $order->with("order_items");
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        // cancel the order
    }
}
