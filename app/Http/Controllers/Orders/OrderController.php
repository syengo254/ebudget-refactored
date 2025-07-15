<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderRequest;
use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\Models\Product;
use Throwable;

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

        if($response->denied()){
            return [
                "success" => false,
                "message" => $response->message(),
            ];
        }

        $validated = $request->validated();
        $cart_id = $validated["cart_id"];
        $cartInSession = request()->session()->get("orders.latest_cart_id", false);

        if ($cartInSession && $cartInSession["cart_id"] == $cart_id) {
            return response()->json([
                "success" => true,
                "message" => "Your order has been created.",
                "order" => $this->orderService->find($cartInSession["order_id"]),
                "extra" => request()->session()->get("orders.latest_cart_id", false),
            ]);
        }

        $orderDTO = $this->orderService->createOrder($validated);

        if ($orderDTO->success) {
            // save cart_id to session to avoid multiple requests
            request()->session()->put("orders.latest_cart_id", [
                "cart_id" => $cart_id,
                "order_id" => $orderDTO->order->id,
            ]);

            Mail::to(Auth::user()->email)->queue(new OrderCreated($orderDTO->order));

            return response()->json([
                "success" => $orderDTO->success,
                "message" => "Your order has been created.",
                "order" => $orderDTO->order,
            ]);
        } else {
            return response()->json([
                "success" => $orderDTO->success,
                "message" => $orderDTO->error?->getMessage() ?? "Failed to create your order.",
                "order" => $orderDTO->order,
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

    public function rules()
    {
        return [
            "order" => "required|array|min:1",
            "order.*.product_id" => "required|integer|min:1|exists:products,id",
            "order.*.count" => "required|integer|min:1",
            "cart_id" => "required|string|min:10"
        ];
    }
}
