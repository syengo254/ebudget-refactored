<?php

namespace App\Services;

use App\Models\User;

class OrderService {

    public function getUserOrders(User $user, int $page, int $limit)
    {
        return $user->orders()->with("order_items")->paginate($limit);
    }

    public function getAllOrders(int $page, int $limit)
    {
        //
    }
}
