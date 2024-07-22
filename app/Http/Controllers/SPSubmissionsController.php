<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SPSubmissionsController extends Controller
{
    public function show(int $projectId, $submissionType)
    {
        $project = Project::findOrFail($projectId);
        // Find the submission based on project and type
        $submission = Submission::where('project_id', $projectId)
            ->where('type', $submissionType)
            ->first();

        return view('Users.Supervisor.sp-submission', compact('project', 'submissionType', 'submission'));
    }

    public function submitFeedback(Request $request, Submission $submission)
    {
        // Validate feedback input
        $request->validate([
            'feedback' => 'required|string|max:255',
        ]);

        // Update the submission feedback
        $submission->update([
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('status', 'Feedback submitted successfully!');
    }

    public function download($submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        return response()->download(storage_path("app/{$submission->doc_path}"));
    }
}
