<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cutoff;
use App\Models\College;
use App\Models\Course;
use Illuminate\Http\Request;

class CutoffController extends Controller
{
    public function index(Request $request)
    {
        $query = Cutoff::with(['college', 'course']);

        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $cutoffs = $query->orderBy('year', 'desc')
                         ->orderBy('college_id')
                         ->orderBy('round')
                         ->paginate(50)
                         ->appends($request->all());

        $colleges = College::orderBy('college_name')->get(['college_id', 'college_name']);
        
        // Extract unique years and categories for filters
        $years = Cutoff::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $categories = Cutoff::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.cutoffs.index', compact('cutoffs', 'colleges', 'years', 'categories'));
    }

    public function create()
    {
        $colleges = College::orderBy('college_name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.cutoffs.create', compact('colleges', 'courses'));
    }

    public function manage()
    {
        $colleges = College::orderBy('college_name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.cutoffs.manage', compact('colleges', 'courses'));
    }

    public function fetchManaged(Request $request)
    {
        $cutoffs = Cutoff::where('college_id', $request->college_id)
            ->where('course_id', $request->course_id)
            ->where('year', $request->year)
            ->where('round', $request->round)
            ->get();
            
        return response()->json($cutoffs);
    }

    public function storeManaged(Request $request)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,college_id',
            'course_id' => 'required|exists:courses,id',
            'year' => 'required|integer|min:2000',
            'round' => 'required|string|max:50',
            'cutoffs' => 'required|array|min:1',
            'cutoffs.*.quota' => 'required|string|max:255',
            'cutoffs.*.category' => 'required|string|max:255',
            'cutoffs.*.closing_rank' => 'required|integer',
            'cutoffs.*.closing_score' => 'nullable|integer',
        ]);

        foreach ($validated['cutoffs'] as $c) {
            Cutoff::updateOrCreate(
                [
                    'college_id' => $validated['college_id'],
                    'course_id' => $validated['course_id'],
                    'year' => $validated['year'],
                    'round' => $validated['round'],
                    'quota' => $c['quota'],
                    'category' => $c['category'],
                ],
                [
                    'closing_rank' => $c['closing_rank'],
                    'closing_score' => $c['closing_score'],
                ]
            );
        }

        // Auto-sync closing ranks back to colleges table
        $this->syncCutoffsToCollege($validated['college_id']);

        return redirect()->route('admin.cutoffs.index')->with('success', 'Cutoffs managed successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,college_id',
            'course_id' => 'required|exists:courses,id',
            'category' => 'required|string|max:255',
            'quota' => 'required|string|max:255',
            'round' => 'required|string|max:50',
            'year' => 'required|integer|min:2000',
            'closing_rank' => 'required|integer',
            'closing_score' => 'nullable|integer',
        ]);

        Cutoff::create($validated);

        // Auto-sync closing ranks back to colleges table
        $this->syncCutoffsToCollege($validated['college_id']);

        return redirect()->route('admin.cutoffs.index')->with('success', 'Cutoff record created successfully.');
    }

    public function edit(Cutoff $cutoff)
    {
        $colleges = College::orderBy('college_name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.cutoffs.edit', compact('cutoff', 'colleges', 'courses'));
    }

    public function update(Request $request, Cutoff $cutoff)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,college_id',
            'course_id' => 'required|exists:courses,id',
            'category' => 'required|string|max:255',
            'quota' => 'required|string|max:255',
            'round' => 'required|string|max:50',
            'year' => 'required|integer|min:2000',
            'closing_rank' => 'required|integer',
            'closing_score' => 'nullable|integer',
        ]);

        $cutoff->update($validated);

        // Auto-sync closing ranks back to colleges table
        $this->syncCutoffsToCollege($validated['college_id']);

        return redirect()->route('admin.cutoffs.index')->with('success', 'Cutoff record updated successfully.');
    }

    public function destroy(Cutoff $cutoff)
    {
        $collegeId = $cutoff->college_id;
        $cutoff->delete();

        // Auto-sync closing ranks back to colleges table
        $this->syncCutoffsToCollege($collegeId);

        return redirect()->route('admin.cutoffs.index')->with('success', 'Cutoff record deleted successfully.');
    }

    /**
     * Sync the latest cutoff closing ranks back to the colleges table.
     */
    private function syncCutoffsToCollege(int $collegeId): void
    {
        $college = College::find($collegeId);
        if (!$college) return;

        $categoryMap = [
            'UR'  => 'general_rank',
            'OBC' => 'obc_rank',
            'SC'  => 'sc_rank',
            'ST'  => 'st_rank',
        ];

        foreach ($categoryMap as $category => $column) {
            $latest = Cutoff::where('college_id', $collegeId)
                ->where('category', $category)
                ->orderBy('year', 'desc')
                ->first();

            $college->$column = $latest ? $latest->closing_rank : null;
        }

        // Temporarily disable the model observer to avoid infinite loop
        College::withoutEvents(function () use ($college) {
            $college->save();
        });
    }
}
