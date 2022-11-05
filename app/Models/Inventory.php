<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sku', 'in_stock'];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
