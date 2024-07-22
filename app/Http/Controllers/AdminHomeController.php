<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cohort;

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
            'document' => 'required|file|mimes:xls,xlsx,csv|max:10240'
        ]);
        $file = $request->file('student_details');
    }

    public function show()
    {
    }
}
