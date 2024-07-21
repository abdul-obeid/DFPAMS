<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MeetingLog;
use Illuminate\Support\Str;

class STMeetingLogController extends Controller
{
    public function index(Request $request, int $logNum)
    {
        $user = Auth::user();
        $project = $user->userable->project()->first();
        return view('Users.Student.st-meeting-logs')->with('logNum', $logNum)->with('project', $project);
    }

    public function store(Request $request, int $logNum)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:2048', // Adjust validation rules as needed
        ]);

        $file = $request->file('document');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('meeting_logs', $filename);

        $originalFilename = $file->getClientOriginalName();

        $projectId = $request->input('project_id');

        $meetingLog = new MeetingLog();
        $meetingLog->log_num = $logNum;
        $meetingLog->project_id = $projectId;
        $meetingLog->submission_name = $originalFilename;
        $meetingLog->submission_path = $filePath;
        $meetingLog->is_approved = false;
        $meetingLog->supervisor_feedback = 'None.';
        $meetingLog->save();

        return redirect()->route('student-homepage.index')->with('success', 'Meeting log #' . $logNum . ' successfully submitted!');
    }
}
