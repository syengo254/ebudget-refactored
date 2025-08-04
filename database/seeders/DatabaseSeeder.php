<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->count(1)->create([
            "email" => "david@example.com",
            "name" => "David Syengo",
            "has_store" => false,
        ]);
        \App\Models\User::factory()->count(1)->create([
            "email" => "wyda.super@example.com",
            "name" => "Wyda & Sons LTD",
            "has_store" => true,
        ]);

        \App\Models\Category::factory(8)->create();
        \App\Models\Product::factory(32)->create();
    }
}
