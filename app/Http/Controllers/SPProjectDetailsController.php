<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class SPProjectDetailsController extends Controller
{
    public function index(Request $request, $projectId)
    {
        $project = Project::with('students', 'meetingLogs')->find($projectId);

        return view('Users.Supervisor.sp-project-details', compact('project'));
    }
}
