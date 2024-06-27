<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cohort;

class AdminHomeController extends Controller
{
    public function index()
    {
        $cohorts = Cohort::withCount('students')->get();
        return view('Users.Admin.admin-homepage', compact('cohorts'));
    }

    public function store()
    {
    }

    public function show()
    {
    }
}
