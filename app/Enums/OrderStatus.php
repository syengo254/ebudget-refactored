<?php

namespace App\Enums;

enum OrderStatus:string {
    case NEW = "new";
    case CONFIRMED = "confirmed";
    case PENDING = "pending";
    case AWAITING_VENDOR_CONFIRMATION = "awaiting";
    case DELIVERING = "delivering";
    case DELIVERED = "delivered";
    case CANCELLED = "cancelled";
}
