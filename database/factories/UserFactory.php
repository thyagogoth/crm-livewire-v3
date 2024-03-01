<?php

namespace Database\Factories;

use App\Enums\Can;
use App\Models\{User};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withPermission(Can $key): static
    {
        return $this->afterCreating(function (User $user) use ($key) {
            $user->givePermissionTo($key);
        });
    }

    public function admin(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->givePermissionTo(Can::BE_AN_ADMIN);
        });
    }

    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
        ]);
    }

    public function withValidationCode(): static
    {
        return $this->state(fn () => [
            'validation_code' => random_int(100000, 999999),
        ]);
    }
}
