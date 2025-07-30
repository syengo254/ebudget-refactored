<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Profile;
use App\Models\Store;
use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'has_store' => fake()->randomElement([true, false]),
            'password' => Hash::make('Password1234!'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function(User $user){
            // create profile & addresses
            $user->profile()->save(Profile::factory()->hasAddresses()->create());

            // create store if true
            if($user->has_store){
                $user->store()->save(Store::factory()->make());
            }

            // create user_settings
            $user->userSettings()->save(UserSettings::factory()->make());
        });
    }
}
