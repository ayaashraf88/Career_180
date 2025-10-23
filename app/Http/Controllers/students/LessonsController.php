<?php

namespace App\Http\Controllers\students;

use App\DTOs\Lesson\MarkAsCompleted;
use App\DTOs\Lesson\MarkAsCompletedData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    protected $MarkAsCompleted;
    public function __construct(MarkAsCompleted $MarkAsCompleted)
    {
        $this->MarkAsCompleted = $MarkAsCompleted;
    }
   
}
