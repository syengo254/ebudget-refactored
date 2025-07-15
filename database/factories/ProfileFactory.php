<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first() ?? User::factory(),
            'phone' => $this->faker->phoneNumber(),
            'active_address_id' => null, // can be set after creating address
        ];
    }
} 