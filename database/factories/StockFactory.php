<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 100),
            'cost_price' => $this->faker->randomFloat(2, 50, 500),
            'selling_price' => $this->faker->randomFloat(2, 100, 1000),
            'remarks' => $this->faker->sentence,
            'user_id' => User::factory(), 
        ];
    }
}
