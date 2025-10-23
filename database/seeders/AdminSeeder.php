<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Admin::factory()->create([
            'name' => 'admin',
            'email' => 'admin@Career180.com',
            'password' => bcrypt('admin123'),
            'verified' => true,
            'verified_at' => now(),
        ]);
    }
}
