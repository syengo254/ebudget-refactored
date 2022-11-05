<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function subCategories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
    }

    public function hasParent()
    {
        return $this->parent_id;
    }
}
