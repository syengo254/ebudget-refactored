<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => fake()->randomElement([
                "Sony Plasma TV 22-Inch Black Full HD",
                "iPhone 12 mini",
                "Samsung TV 32-inch",
                "Lenovo Legion Laptop",
                "Ms Windows 10 Home Basic Disc",
                "6x6m Square Carpet - Imported",
                "Size 16 Kids Bike",
                "Bata Slippers"
            ]),
            "category_id" => Category::inRandomOrder()->first() ?? Category::factory(),
            "price" => fake()->numberBetween(50_000, 250_000),
            "store_id" => Store::inRandomOrder()->first() ?? Store::factory(),
            "stock_amount" => fake()->numberBetween(1, 10),
            "image" => fake()->randomElement([
                'products/colgate-toothpaste.jpg',
                'products/geisha.jpg',
                'products/Sony_Television_LCD.png',
                'products/iphone12.jpg',
                'products/Samsung_DUOS.png'
            ]),
        ];
    }
}
