<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'name', 
        'price', 
        'store_id', 
        'stock_amount',
        'image',
    ];

    protected $hidden = [
        "remember_token",
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function store() 
    {
        return $this->belongsTo(Store::class);
    }

    protected function image(): CastsAttribute
    {
        return CastsAttribute::make(
            get: fn ($value) => asset('storage/' . $value),
        );
    }
}
