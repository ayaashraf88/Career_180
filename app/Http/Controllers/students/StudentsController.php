<?php

namespace App\Http\Controllers\students;

use App\Actions\Student\UpdateProfile;
use App\DTOs\Student\UpdateProfileData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    protected $UpdateProfile;
    public function __construct(UpdateProfile $UpdateProfile)
    {
        $this->UpdateProfile = $UpdateProfile;
    }
    public function profile()
    {
        $student = auth()->guard('student')->user();
        return view('students.profile', compact('student'));
    }
    public function update(Request $request)
    {
        $UpdateProfileData = UpdateProfileData::fromRequest($request);
        $user = $this->UpdateProfile->execute($UpdateProfileData);
        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }
}
