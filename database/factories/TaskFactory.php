<?php

namespace Database\Factories;

use App\Models\{Customer, User};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'assigned_to' => fake()->boolean() ? null : User::factory(),
            'title'       => fake()->sentence,
            'title'       => fake()->sentence,
            'done_at'     => fake()->boolean() ? fake()->dateTimeBetween('-1 year', 'now') : null,
        ];
    }
}
