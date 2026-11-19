<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = \App\Models\Course::paginate(12);
        return view('courses.index', compact('courses'));
    }
}