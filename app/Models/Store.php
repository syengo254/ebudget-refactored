<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'password', 'logo', 'email', 'active_address_id'];
    protected $hidden = ['password'];

    protected function logo(): CastsAttribute
    {
        return CastsAttribute::make(
            get: fn ($value) => asset('storage/' . $value),
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }

    public function getActiveAddress()
    {
        if ($this->active_address_id) {
            return Address::find($this->active_address_id);
        }
        return null;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
