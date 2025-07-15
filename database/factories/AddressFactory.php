<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'profile_id' => Profile::inRandomOrder()->first() ?? Profile::factory(),
            'city' => $this->faker->city(),
            'town' => $this->faker->city(),
            'building' => $this->faker->buildingNumber(),
            'floor' => $this->faker->numberBetween(1, 10),
            'additional_info' => $this->faker->sentence(),
        ];
    }
}
