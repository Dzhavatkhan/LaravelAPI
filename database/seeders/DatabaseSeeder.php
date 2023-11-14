<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Factories\ProductFactory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Bruce Wayne',
            'email' => 'user@samohod.ru',
            'password' => bcrypt('password')
        ]);
        \App\Models\Admin::factory()->create([
            "email" => "admin@samohod.ru",
            "password" => bcrypt('1234Qw-')
        ]);
        Product::factory()->count(10)->create();
        Cart::factory()->count(100)->create();
        User::factory(10)->create();
        Order::factory()->count(50)->create();
    }
}
