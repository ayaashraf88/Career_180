<?php

namespace App\Actions\Student;

use App\DTOs\Student\UpdateProfileData;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UpdateProfile
{
    /**
     * Handle an incoming authentication request.
     *
     * @throws ValidationException
     */
    public function execute(UpdateProfileData $data)
    {
        $student = auth()->guard('student')->user();

        if (!empty($data->password)) {
            $student->password = bcrypt($data->password);
        }
        $student->update($data->toArray());
        activity()
            ->causedBy($student)
            ->log('user updated');
        return $student->refresh();
    }
}
