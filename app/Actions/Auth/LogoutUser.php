<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LogoutUser
{
    /**
     * Handle an incoming authentication request.
     *
     * @throws ValidationException
     */
    public function handle(Request $request)
    {
        activity()
            ->causedBy(Auth::guard('student')->user())
            ->log('user logged out');
        Auth::guard('student')->logout();
    }
}
