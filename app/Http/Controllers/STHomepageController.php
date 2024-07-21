<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class STHomepageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $project = $user->userable->project()->first();
        $supervisor = $project->supervisor()->first();
        return view('Users.Student.st-homepage')->with(compact(['user', 'project', 'supervisor']));
    }
}
