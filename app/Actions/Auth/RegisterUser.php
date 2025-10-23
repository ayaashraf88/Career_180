<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\RegiserData;
use App\Models\Student;
use App\Notifications\RegistrationNotification;
use Filament\Pages\Auth\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegisterUser
{
    /**
     * Handle an incoming authentication request.
     *
     * @throws ValidationException
     */
    public function execute(RegiserData $data)
    {

        if (Student::where('email', $data->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email already registered',
            ]);
        }
        $student = Student::create([
            'name'     => $data->name,
            'email'    => $data->email,
            'password' => bcrypt($data->password),
        ]);

        $student->notify(new RegistrationNotification($student));

        activity()
            ->causedBy($student)
            ->log('registered as new student');
        if (!Auth::guard('student')->attempt([
            'email' => $data->email,
            'password' => $data->password,
        ], $data->remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        request()->session()->regenerate();
        return Auth::guard('student')->user();
    }
}
