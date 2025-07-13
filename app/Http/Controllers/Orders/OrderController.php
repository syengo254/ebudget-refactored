<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{

    public function __construct(protected OrderService $orderService){}
    
    public function index(Request $request, int $page = 1, int $limit = 15)
    {
        return $this->orderService->getUserOrders(Auth::user(), $page, $limit );
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Order $order)
    {
        Gate::define("can-view", function(User $user, Order $order){
            return $user->is($order->user);
        });

        if(Gate::denies("can-view", $order)){
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
