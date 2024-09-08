<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch a user to associate the stock with, or create a default user
        $user = User::first() ?? User::factory()->create();

        // Create 5 random stock items for the user
        Stock::factory()->count(5)->create([
            'user_id' => $user->id, // Ensure stocks are linked to the user
        ]);
    }
}
