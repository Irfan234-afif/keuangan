<?php

namespace Database\Factories;

use App\Models\Balance;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $balanceId = 1;
        return [
            'user_id' => fn() => User::inRandomOrder()->first()->id,
            'balance_id' => $balanceId++,
            'transaction_type_id' => fn() => TransactionType::inRandomOrder()->first()->id,
            'amount' => fake()->numberBetween(10000, 5000000),
            'description' => fake()->sentence(5),
            'transaction_date' => fake()->date(),
        ];
    }
}