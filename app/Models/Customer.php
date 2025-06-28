<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['fullname', 'email', 'password', 'title', 'is_active', 'active_address_id'];
    protected $hidden = ['password'];

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

    public function orders()
    {
        return $this->hasMany(CustomerOrder::class, 'customer_id');
    }
}
