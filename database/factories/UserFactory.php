<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'web_door',
            'last_name' => 'Anton',
            'middle_name' => 'Krivchik',
            'email' => 'anton4ik2251@yandex.ru',
            'phone' => '+79650347115',
            'email_verified_at' => now(),
            'password' => '$2y$10$jBb4tHOvLz6YMJN1ZO.anuXpp1Sdt5pw8WPUZHPIt7mzBd5EY9PPW', // password
            'remember_token' => Str::random(10),
            'actual' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
