<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = ['address_id', 'order_id'];
}
