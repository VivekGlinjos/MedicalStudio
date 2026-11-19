<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\College;
use App\Models\CollegeGallery;
use App\Models\Video;
use App\Models\Enquiry;
use App\Models\User;
use App\Models\BlogPost;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $courseCount = Course::count();
        $collegeCount = College::count();
        $galleryCount = CollegeGallery::count();
        $videoCount = Video::count();
        $userCount = User::count();
        $blogCount = BlogPost::count();
        $enquiryCount = Enquiry::count();
        $enquiry = Enquiry::latest()->take(10)->get();

        return view('admin.dashboard', compact('courseCount', 'collegeCount', 'galleryCount', 'videoCount', 'enquiry', 'userCount', 'blogCount', 'enquiryCount'));
    }
}
