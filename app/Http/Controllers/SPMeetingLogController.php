<?php

namespace App\Http\Controllers;

use App\Models\MeetingLog;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SPMeetingLogController extends Controller
{
    public function index(Request $request, $projId, $logNum)
    {
        $project = Project::findOrFail($projId);
        $meetingLog = $project->meetingLogs->where('log_num', $logNum)->first();
        return view('Users.Supervisor.sp-meeting-log', compact('meetingLog', 'project'));
    }

    public function submitFeedback(Request $request, $projId, $logNum)
    {
        $request->validate([
            'feedback' => 'nullable|string',
        ]);

        $project = Project::findOrFail($projId);
        $meetingLog = $project->meetingLogs->where('log_num', $logNum)->first();
        $meetingLog->supervisor_feedback = $request->input('feedback');
        $meetingLog->save();

        return redirect()->route('supervisor-meeting-log.index', compact('projId', 'logNum'))->with('success', 'Feedback submitted successfully.');
    }


    public function download(Request $request, $projId, $logNum)
    {
        $project = Project::findOrFail($projId);
        $meetingLog = $project->meetingLogs->where('log_num', $logNum)->first();
        return Storage::download($meetingLog->submission_path, $meetingLog->submission_name);
    }
}
