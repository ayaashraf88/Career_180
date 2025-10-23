<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'verified' => $this->faker->boolean(80),
            'verified_at' => $this->faker->optional(70)->dateTimeBetween('-1 year', 'now'),
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'verified' => false,
            'verified_at' => null,
        ]);
    }
}