<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\LoginData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    /**
     * Handle user login.
     *
     * @param LoginData $data
     * @throws ValidationException
     * @return \App\Models\Student
     */
    public function execute(LoginData $data)
    {
        if (!Auth::guard('student')->attempt([
            'email' => $data->email,
            'password' => $data->password,
        ], $data->remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        request()->session()->regenerate();
        activity()
            ->causedBy(Auth::guard('student')->user())
            ->log('user logged in');
        return Auth::guard('student')->user();
    }
}
