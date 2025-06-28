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

    protected $fillable = [
        'name',
        'email', 
        'password', 
        'logo', 
        'phone_number',
        'active_address_id'
    ];
    protected $hidden = ['password', 'remember_token'];

    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


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
}
