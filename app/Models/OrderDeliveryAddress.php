<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = ['address_id', 'order_id'];

    public function customerOrder()
    {
        return $this->belongsTo(CustomerOrder::class, 'order_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
