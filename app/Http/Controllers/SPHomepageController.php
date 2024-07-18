<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SPHomepageController extends Controller
{
    public function index(Request $request)
    {
        return view('Users.Supervisor.sp-homepage');
    }
}
