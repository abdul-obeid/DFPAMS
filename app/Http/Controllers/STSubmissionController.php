<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class STSubmissionController extends Controller
{
    public function index(Request $request, $submissionType)
    {
        return view('Users.Student.st-submission')->with('submissionType', $submissionType);
    }

    public function store(Request $request, $submissionType)
    {
        $file = $request->file('document');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();

        $storageFolder = '';

        switch ($submissionType) {
            case 'Report':
                $request->validate(['document' => 'required|file|mimes:pdf,doc,docx|max:51200']);
                $storageFolder = 'reports';
                break;

            case 'Demo':
                $request->validate(['document' => 'required|file|mimes:mp4,mkv,avi,mov|max:102400']);
                $storageFolder = 'demos';
                dd($storageFolder);
                break;

            case 'Poster':
                $request->validate(['document' => 'required|file|mimes:pdf,doc,docx|max:51200']);
                $storageFolder = 'posters';
                break;

            default:
                return redirect()->route('student-homepage.index')->with('errors', 'Unexpected error. Please try again.');
                break;
        }

        $filePath = $file->storeAs($storageFolder, $filename);

        $originalFilename = $file->getClientOriginalName();

        $user = Auth::user()->userable;
        $projectId = $user->project()->first()->id;

        $submission = new Submission();
        $submission->type = $submissionType;
        $submission->project_id = $projectId;
        $submission->feedback = 'None.';
        $submission->doc_name = $originalFilename;
        $submission->doc_path = $filePath;

        $submission->save();

        return redirect()->route('student-homepage.index')->with(
            [
                'success' => $submissionType . ' submitted successfully!'
            ]
        );
    }
}
