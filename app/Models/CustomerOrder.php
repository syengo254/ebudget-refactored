<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;
    use UuidTrait;

    protected $fillable = ['customer_id', 'expected_delivery_date', 'delivered_on', 'cancelled_on'];
}
