<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    
    public function definition()
    {
            $name = $this->faker->sentence(2);

        return [
            'name' => $name,
            'description' => $this->faker->paragraph(3),
            'slug' => Str::slug($name),
            'image' => '01K7VS95B34XANVNQDAQ318J36.jpg',
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}