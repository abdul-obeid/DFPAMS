<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SPHomepageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $projects = $user->userable->projects()->with('students')->get();
        return view('Users.Supervisor.sp-homepage')->with('projects', $projects);
    }
}
