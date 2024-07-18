<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::all();
        return view('test')->with('students', $students);
    }
}
