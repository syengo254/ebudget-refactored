<?php

namespace App\Http\DTOs;

use App\Models\Order;
use Throwable;

class OrderDTO {
    public function __construct(public ?Order $order, public bool $success, public ?Throwable $error) {
        $this->order = $order;
        $this->success = $success;
        $this->error = $error;
    }

    public function toArray(): array {
        return [
            "order" => $this->order,
            "success" => $this->success,
            "message" => $this->error?->getMessage(),
        ];
    }
}
