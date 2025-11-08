<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'name' => $this->faker->sentence(2),
             'order'=>$this->faker->numberBetween(1, 100),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
      public function configure()
    {
        static $order = 1;

        return $this->afterMaking(function (Module $module) use (&$order) {
            $module->order = $order++;
        });
    }
}
