<?php

namespace App\Http\Controllers;

use App\Imports\ProjectsImport;
use Illuminate\Http\Request;
use App\Models\Cohort;
use App\Models\Project;
use App\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AdminHomeController extends Controller
{
    public function index(Request $request)
    {
        $cohorts = Cohort::withCount('students')->get();
        return view('Users.Admin.admin-homepage', compact('cohorts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_details' => 'required|file|mimes:xls,xlsx,csv|max:10240'
        ]);
        DB::beginTransaction();
        try {
            $trimester_code = $request->input('trimester_code');
            $cohort_start = $request->input('start_date');
            $cohort_end = $request->input('end_date');

            $start_date = Carbon::createFromFormat('d-m-Y', $cohort_start)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d-m-Y', $cohort_end)->format('Y-m-d');

            $cohort = new Cohort([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'faculty' => 'FCI',
                'trimester_code' => $trimester_code,
            ]);

            $cohort->save();

            $file = $request->file('student_details');
            Excel::import(new ProjectsImport($cohort->id), $file);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Exception occurred: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e;
        }
        Log::info('Cohort successfully created.');
        return redirect()->route('admin.index')->with('success', 'Cohort successfully created.');
    }

    public function show(Request $request, $id)
    {
        // Retrieve cohort
        $cohort = Cohort::findOrFail($id);

        // Get total number of students
        $totalStudents = Student::where('cohort_id', $id)->count();

        // Get number of students per specialization
        $specializations = Student::where('cohort_id', $id)
            ->select('specialization', DB::raw('count(*) as count'))
            ->groupBy('specialization')
            ->pluck('count', 'specialization');

        // Get total number of projects
        $totalProjects = Project::where('cohort_id', $id)->count();

        // Get number of group and individual projects
        $groupProjects = Project::where('cohort_id', $id)
            ->where('is_group_project', true)
            ->count();

        $individualProjects = Project::where('cohort_id', $id)
            ->where('is_group_project', false)
            ->count();

        // Get number of projects with submissions
        $submittedProjects = Project::where('cohort_id', $id)
            ->whereHas('meetingLogs') // Assuming meetingLogs indicate submission
            ->count();

        // Calculate percentage of projects with submissions
        $submissionPercentage = $totalProjects > 0
            ? ($submittedProjects / $totalProjects) * 100
            : 0;

        // Pass data to view
        return view('Users.Admin.cohort-details', [
            'cohort' => $cohort,
            'totalStudents' => $totalStudents,
            'specializations' => $specializations,
            'totalProjects' => $totalProjects,
            'groupProjects' => $groupProjects,
            'individualProjects' => $individualProjects,
            'submittedProjects' => $submittedProjects,
            'submissionPercentage' => number_format($submissionPercentage, 2),
        ]);
    }
}
