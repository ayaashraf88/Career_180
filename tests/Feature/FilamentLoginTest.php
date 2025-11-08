<?php

use App\Models\Admin;
use App\Models\Student;

it('Filament Admin is not  accessible student', function () {
    $student = Student::factory()->create();
    $this->actingAs($student, 'student')
        ->get('/admin')
        ->assertRedirect('/admin/login');
});
it('Filament Admin is accessible only for admins', function () {
    $admin = Admin::factory()->create();
    $this->actingAs($admin, 'admin')
        ->get('/admin')
        ->assertRedirect('/admin/dashboard');
});
