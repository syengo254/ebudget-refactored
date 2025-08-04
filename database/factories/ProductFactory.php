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
            'name' => fake()->randomElement([
                'Sony Plasma TV 22-Inch Black Full HD',
                'iPhone 12 mini',
                'Samsung TV 32-inch',
                'Lenovo Legion Laptop',
                'Ms Windows 10 Home Basic Disc',
                '6x6m Square Carpet - Imported',
                'Size 16 Kids Bike',
                'Bata Slippers',
                'Magnum condoms',
                'Coffee maker 2Ltrs',
                'Gillette Shavers (3-in-1)',
                'Delmonte Mango Juice 1 Liter Packet'
            ]),
            'category_id' => Category::inRandomOrder()->first() ?? Category::factory(),
            'price' => fake()->numberBetween(50_000, 250_000),
            'store_id' => Store::inRandomOrder()->first() ?? Store::factory(),
            'stock_amount' => fake()->numberBetween(5, 10),
            'image' => fake()->randomElement([
                'products/colgate-toothpaste.jpg',
                'products/geisha.jpg',
                'products/Sony_Television_LCD.png',
                'products/iphone12.jpg',
                'products/Samsung_DUOS.png',
                'product-images/3vQDsvzp3wvofPmHpRaWLaPG4syysYJAYHRB5srP.webp',
                'product-images/ycSvMbfa3j12GhCSfLssOHehdSGJCSUflHmOdRr8.jpg',
                'product-images/yrLVLmw0WbqwB7tEpkdnBTRarSkDDlQBBWvIxAPh.jpg',
            ]),
        ];
    }
}
