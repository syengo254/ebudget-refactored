<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Store extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'password', 'logo', 'email', 'active_address_id'];
    protected $hidden = ['password'];

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
