<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class STMeetingLogController extends Controller
{
    public function index(Request $request, int $logNum)
    {
        return view('Users.Student.st-meeting-logs')->with('logNum', $logNum);
    }

    public function store(Request $request, int $logNum)
    {
        return view('Users.Student.st-meeting-logs')->with(
            [
                'logNum' => $logNum,
                'success' => 'Meeting log ' . $logNum . ' successfully submitted!',
            ]
        );
    }
}
