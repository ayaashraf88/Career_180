<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'module_id' => Module::factory(),
            'title' => $this->faker->sentence(4),
            'content' => substr($this->faker->text(), 0, 25), // Limit to 25 chars
            'video_url' => '01K7W0C8X6549C5EQJJ920JRSJ.mp4',
            'duration' => $this->faker->numberBetween(5, 120),
            'visible' => (bool) mt_rand(0, 1),
            'order'=>$this->faker->randomIn(2, 10, 500),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function free()
    {
        return $this->state(fn (array $attributes) => [
            'visible' => true,
        ]);
    }

    public function short()
    {
        return $this->state(fn (array $attributes) => [
            'duration' => $this->faker->numberBetween(5, 15),
        ]);
    }

    public function long()
    {
        return $this->state(fn (array $attributes) => [
            'duration' => $this->faker->numberBetween(60, 120),
        ]);
    }

    public function locked()
    {
        return $this->state(fn (array $attributes) => [
            'visible' => false,
        ]);
    }
}
