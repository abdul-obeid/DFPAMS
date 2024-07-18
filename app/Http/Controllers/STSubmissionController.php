<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class STSubmissionController extends Controller
{
    public function index(Request $request, $submissionType)
    {
        return view('Users.Student.st-submission')->with('submissionType', $submissionType);
    }

    public function store(Request $request, $submissionType)
    {
        return view('Users.Student.st-meeting-logs')->with(
            [
                'submissionType' => $submissionType,
            ]
        );
    }
}
