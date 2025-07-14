<?php

namespace App\Enums;

enum OrderStatus:string {
    case NEW = "new";
    case PENDING = "pending";
    case DELIVERING = "delivering";
    case DELIVERED = "delivered";
    case CANCELLED = "cancelled";
}
