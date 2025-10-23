<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'name' => $this->faker->sentence(2),
            'order' => $this->faker->randomIn(2, 10, 500),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
