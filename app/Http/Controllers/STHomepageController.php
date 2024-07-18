<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Student;
use App\Models\ProjectStudents;
use App\Models\MeetingLog;
use App\Models\Submission;



class STHomepageController extends Controller
{
    public function index(Request $request)
    {
        $studentId = 53;
        $student = User::find(53)->userable();
        return view('Users.Student.st-homepage');
    }
}
