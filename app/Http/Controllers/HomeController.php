<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Course;
use App\Models\State;
use App\Models\Enquiry;
use App\Models\BlogPost;

class HomeController extends Controller
{
    public function index()
    {
        $collegeCount = College::where('is_active', true)->count();
        $courseCount = Course::where('is_active', true)->count();
        $stateCount = State::count();
        $studentCount = Enquiry::count(); // enquiries as a proxy for students helped

        return view('home', compact('collegeCount', 'courseCount', 'stateCount', 'studentCount'));
    }
}
