<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['postal_code', 'street', 'phone', 'city', 'more_info', 'store_id', 'customer_id'];
}
