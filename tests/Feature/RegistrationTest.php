<?php

use App\Actions\Auth\RegisterUser;
use App\DTOs\Auth\RegiserData;
use App\Models\Student;
use App\Notifications\RegistrationNotification;
use Illuminate\Support\Facades\Notification;

it('sends welcome email on registration', function () {
    Notification::fake();
    $data = new RegiserData(
        name: 'Test User',
        email: 'testuser@example.com',
        password: 'password123',
        remember: false
    );
    request()->setLaravelSession(app('session')->driver());
    $action = new RegisterUser();
    $user = $action->execute($data);
    $this->assertInstanceOf(Student::class, $user);
    $this->assertDatabaseHas('students', ['email' => 'testuser@example.com']);
    Notification::assertSentTo(
        [$user],
        RegistrationNotification::class,
        function ($notification, $channels) use ($user) {
            return $notification->student->id === $user->id;
        }
    );
});
