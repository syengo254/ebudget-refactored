<?php

namespace App\Models;

use App\Jobs\SendVerifyEmailJob;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'has_store',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected function hasStore(): Attribute
    {
        return Attribute::make(
            get: fn($value) => boolval($value)
        );
    }

    public function isVerified(): bool
    {
        return boolval($this->email_verified_at);
    }

    
    public function store(): HasOne
    {
        // if(! $this->has_Store){
        //     return NULL;
        // }

        return $this->hasOne(Store::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function sendEmailVerificationNotification()
    {
        SendVerifyEmailJob::dispatch($this);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
