<?php

namespace App\Http\Controllers\Orders;

use App\Actions\SendOrderEmails;
use App\Http\Controllers\Controller;
use App\Http\DTOs\OrderDTO;
use App\Http\Requests\Orders\OrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Exception;

class OrderController extends Controller
{

    public function __construct(protected OrderService $orderService) {}

    public function index(Request $request, int $page = 1, int $limit = 15)
    {
        return $this->orderService->getUserOrders(Auth::user(), $page, $limit);
    }

    public function store(OrderRequest $request)
    {
        $response = Gate::inspect('create', new Order);

        if ($response->denied()) {
            return (new OrderDTO(null, false, new Exception($response->message())))->toArray();
        }

        $validated = $request->validated();
        $cart_id = $validated["cart_id"];
        $cartInSession = request()->session()->get("orders.latest_cart_id", false);

        if ($cartInSession && $cartInSession["cart_id"] == $cart_id) {
            return (new OrderDTO(
                $this->orderService->find($cartInSession["order_id"]),
                true,
                new Exception("Order already exists")
            ))->toArray();
        }

        $orderDTO = $this->orderService->createOrder($validated);

        if ($orderDTO->success) {
            // save cart_id to session to avoid multiple requests
            request()->session()->put("orders.latest_cart_id", [
                "cart_id" => $cart_id,
                "order_id" => $orderDTO->order->id,
            ]);

            (new SendOrderEmails())->handle($orderDTO->order);
        }

        return response()->json([
            "success" => $orderDTO->success,
            "message" => $orderDTO->success
                ? "Your order has been created."
                : $orderDTO->error?->getMessage() ?? "Failed to create your order.",
            "order" => $orderDTO->order,
        ]);
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
