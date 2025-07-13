<?php

namespace App\Enums;

enum OrderStatus:string {
    case PENDING = "pending";
    case DELIVERING = "delivering";
    case CANCELLED = "cancelled";
    case DELIVERED = "delivered";
}
