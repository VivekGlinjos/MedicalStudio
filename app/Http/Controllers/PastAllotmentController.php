<?php

namespace App\Http\Controllers;

use App\Models\Cutoff;
use App\Models\College;
use App\Models\State;
use App\Models\Course;
use Illuminate\Http\Request;

class PastAllotmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Cutoff::with(['college.stateRelation', 'course']);

        if ($request->filled('search')) {
            $query->whereHas('college', function($q) use ($request) {
                $q->where('college_name', 'like', '%' . $request->search . '%')
                  ->orWhere('state', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('state_id')) {
            $query->whereHas('college', function($q) use ($request) {
                if (is_array($request->state_id)) {
                    $q->whereIn('state_id', $request->state_id);
                } else {
                    $q->where('state_id', $request->state_id);
                }
            });
        }
        
        if ($request->filled('college_type')) {
            $query->whereHas('college', function($q) use ($request) {
                if (is_array($request->college_type)) {
                    $q->whereIn('college_type', $request->college_type);
                } else {
                    $q->where('college_type', $request->college_type);
                }
            });
        }

        if ($request->filled('college_id')) {
            if (is_array($request->college_id)) {
                $query->whereIn('college_id', $request->college_id);
            } else {
                $query->where('college_id', $request->college_id);
            }
        }

        if ($request->filled('course_id')) {
            if (is_array($request->course_id)) {
                $query->whereIn('course_id', $request->course_id);
            } else {
                $query->where('course_id', $request->course_id);
            }
        }

        if ($request->filled('year')) {
            if (is_array($request->year)) {
                $query->whereIn('year', $request->year);
            } else {
                $query->where('year', $request->year);
            }
        }

        if ($request->filled('round')) {
            if (is_array($request->round)) {
                $query->whereIn('round', $request->round);
            } else {
                $query->where('round', $request->round);
            }
        }

        if ($request->filled('category')) {
            if (is_array($request->category)) {
                $query->whereIn('category', $request->category);
            } else {
                $query->where('category', $request->category);
            }
        }

        if ($request->filled('quota')) {
            if (is_array($request->quota)) {
                $query->whereIn('quota', $request->quota);
            } else {
                $query->where('quota', $request->quota);
            }
        }
        
        if ($request->filled('your_rank')) {
            $query->where('closing_rank', '>=', (int) $request->your_rank);
        }

        // Sorting Logic
        if ($request->filled('sort_by')) {
            if ($request->sort_by === 'rank_asc') {
                $query->orderBy('closing_rank', 'asc');
            } elseif ($request->sort_by === 'rank_desc') {
                $query->orderBy('closing_rank', 'desc');
            } elseif ($request->sort_by === 'score_desc') {
                $query->orderBy('closing_score', 'desc');
            }
        } else {
            // Default sorting
            $query->orderBy('year', 'desc')
                  ->orderBy('round')
                  ->orderBy('closing_rank', 'asc');
        }

        $cutoffs = $query->paginate(50)
                         ->appends($request->all());

        // For Filter Dropdowns
        $states = State::orderBy('name')->get(['id', 'name']);
        $colleges = College::orderBy('college_name')->get(['college_id', 'college_name']);
        $courses = Course::orderBy('name')->get(['id', 'name']);
        $years = Cutoff::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $rounds = Cutoff::select('round')->distinct()->orderBy('round')->pluck('round');
        $categories = Cutoff::select('category')->distinct()->orderBy('category')->pluck('category');
        $quotas = Cutoff::select('quota')->distinct()->orderBy('quota')->pluck('quota');

        return view('past-allotments.index', compact(
            'cutoffs', 'states', 'colleges', 'courses', 'years', 'rounds', 'categories', 'quotas'
        ));
    }
}
