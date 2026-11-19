<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\State;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function index(Request $request)
    {
        // Public view only shows active colleges
        $query = College::with('stateRelation')->where('is_active', 1);

        if ($request->has('state_id') && $request->state_id != '') {
            $query->where('state_id', $request->state_id);
        }

        // Also support 'state' param (ID) from states page
        if ($request->has('state') && $request->state != '' && !$request->has('state_id')) {
            $query->where('state_id', $request->state);
        }

        if ($request->has('college_type') && $request->college_type != '') {
            $query->where('college_type', $request->college_type);
        }

        // Filter by course slug
        if ($request->filled('course_slug')) {
            $course = \App\Models\Course::where('slug', $request->course_slug)->first();
            if ($course) {
                $query->where('courses', 'like', "%{$course->name}%");
            }
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($qr) use ($q) {
                $qr->where('college_name', 'like', "%$q%")
                   ->orWhere('place', 'like', "%$q%");
            });
        }

        // Sorting Logic
        if ($request->filled('sort_by')) {
            $sortBy = $request->sort_by;
            if (in_array($sortBy, ['general_rank', 'obc_rank', 'sc_rank', 'st_rank', 'total_seats'])) {
                $query->orderBy($sortBy, 'asc');
            }
        } else {
            $query->orderBy('college_name', 'asc');
        }

        $colleges = $query->paginate(50)->withQueryString();
        $states = State::orderBy('name')->get(['id', 'name']);
        $courses = \App\Models\Course::orderBy('name')->get(['id', 'name', 'slug']);

        return view('colleges.index', compact('colleges', 'states', 'courses'));
    }

    public function show($slug)
    {
        $college = College::where('slug', $slug)
            ->where('is_active', 1)
            ->with(['stateRelation', 'galleries', 'cutoffs', 'seatMatrices'])
            ->firstOrFail();

        $relatedColleges = College::where('state_id', $college->state_id)
            ->where('college_id', '!=', $college->college_id)
            ->where('is_active', 1)
            ->limit(6)
            ->get();

        return view('colleges.show', compact('college', 'relatedColleges'));
    }
}
