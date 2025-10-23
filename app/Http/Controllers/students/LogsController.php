<?php

namespace App\Http\Controllers\students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogsController extends Controller
{
    function showLogs()  {
        $logs= Activity::causedBy(auth()->guard('student')->user())->with('subject')->latest()->get();
        return view('students.logs', ['logs'=>$logs]);
    }
}
