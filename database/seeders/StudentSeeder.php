<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Student::factory()->count(50)->create();

        Student::factory()->create([
            'name' => 'Test Student',
            'email' => 'student@Career180.com',
            'password' => bcrypt('123456'),
            'verified' => true,
            'verified_at' => now(),
        ]);
    }
}
