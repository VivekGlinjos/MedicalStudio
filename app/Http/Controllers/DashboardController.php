<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    private function getUser()
    {
        return auth()->user() ?? (object)[
            'name' => 'Student',
            'email' => 'guest@medicalstudio.com'
        ];
    }

    public function index()
    {
        $user = $this->getUser();
        $videos = \App\Models\Video::latest()->take(3)->get();
        return view('dashboard.index', compact('user', 'videos'));
    }

    public function rankScan(\Illuminate\Http\Request $request)
    {
        $predictedColleges = collect();
        $highChance = collect();
        $borderline = collect();
        $lowChance = collect();
        $user = $this->getUser();
        $states = \App\Models\State::orderBy('name')->get();
        $courses = \App\Models\Course::orderBy('name')->get();
        
        if ($request->filled('rank')) {
            $rank = (int) $request->input('rank');
            $category = strtoupper($request->input('category', 'GEN'));
            $quota = strtolower($request->input('quota', 'all'));
            $stateId = $request->input('state_id');

            // Map frontend category to cutoffs table category
            $dbCategory = match ($category) {
                'OBC' => 'OBC',
                'SC'  => 'SC',
                'ST'  => 'ST',
                'EW', 'EWS' => 'EWS',
                default => 'UR', // Map GEN, EZ, MU, LA, etc. to UR
            };

            // Map category to rank column for colleges table fallback
            $rankColumn = match ($category) {
                'OBC'   => 'obc_rank',
                'SC'    => 'sc_rank',
                'ST'    => 'st_rank',
                default => 'general_rank',
            };

            // Try cutoffs table first (more granular data)
            $cutoffQuery = \App\Models\Cutoff::with(['college.stateRelation', 'course'])
                ->where('category', $dbCategory)
                ->has('college');

            // Apply quota filter
            switch ($quota) {
                case 'aiq':
                    $cutoffQuery->where('quota', 'AIQ');
                    break;
                case 'state':
                    $cutoffQuery->where('quota', 'State');
                    if ($stateId) {
                        $cutoffQuery->whereHas('college', fn($q) => $q->where('state_id', $stateId));
                    }
                    break;
                case 'deemed':
                    $cutoffQuery->whereHas('college', fn($q) => $q->where('college_type', 2));
                    break;
                case 'central':
                    $cutoffQuery->whereHas('college', fn($q) => $q->where('college_type', 3));
                    break;
            }

            $allCutoffs = $cutoffQuery->get();

            // Classify into 3 tiers
            foreach ($allCutoffs as $cutoff) {
                $closingRank = $cutoff->closing_rank;
                $buffer = $closingRank * 0.10;
                $diff = $closingRank - $rank;

                if ($diff > $buffer) {
                    $highChance->push($cutoff);
                } elseif ($diff >= -$buffer) {
                    $borderline->push($cutoff);
                } else {
                    $lowChance->push($cutoff);
                }
            }

            // Sort each tier
            $highChance = $highChance->sortBy('closing_rank');
            $borderline = $borderline->sortBy('closing_rank');
            $lowChance = $lowChance->sortBy('closing_rank');

            // Combine for backward-compatible view
            $predictedColleges = $highChance->merge($borderline)->merge($lowChance);
            
            // Paginate the collection to prevent browser freezing
            $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
            $perPage = 50;
            $predictedColleges = new \Illuminate\Pagination\LengthAwarePaginator(
                $predictedColleges->forPage($page, $perPage),
                $predictedColleges->count(),
                $perPage,
                $page,
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
            );
        }

        return view('dashboard.rank-scan', compact(
            'predictedColleges', 'highChance', 'borderline', 'lowChance',
            'user', 'states', 'courses'
        ));
    }

    public function allotment(\Illuminate\Http\Request $request)
    {
        $user = $this->getUser();
        
        // Feature is "Coming Soon" - bypassing database queries since LiveAllotment doesn't exist yet
        $totalAllotments = 0;
        $virtualVacancies = 0;
        $clearCutSeats = 0;
        
        $allotments = new \Illuminate\Pagination\LengthAwarePaginator(
            [], 0, 50, 1, ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
        $categories = collect();

        return view('dashboard.allotment', compact(
            'user', 'allotments', 'totalAllotments', 'virtualVacancies', 'clearCutSeats', 'categories'
        ));
    }

    public function seatMatrix(\Illuminate\Http\Request $request)
    {
        $user = $this->getUser();
        $query = \App\Models\College::with(['stateRelation', 'seatMatrices.course'])
            ->where('total_seats', '>', 0);
        
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->input('state_id'));
        }
        
        if ($request->filled('course_id')) {
            $query->whereHas('seatMatrices', function($q) use ($request) {
                $q->where('course_id', $request->input('course_id'));
            });
        }

        if ($request->filled('search')) {
            $q = $request->input('search');
            $query->where(function($qr) use ($q) {
                $qr->where('college_name', 'like', "%$q%")
                   ->orWhere('city', 'like', "%$q%")
                   ->orWhere('place', 'like', "%$q%");
            });
        }
        
        $seatMatrices = $query->orderBy('college_name')->paginate(50)->withQueryString();
        $states = \App\Models\State::orderBy('name')->get(['id', 'name']);
        $courses = \App\Models\Course::orderBy('name')->get(['id', 'name']);

        return view('dashboard.seat-matrix', compact('seatMatrices', 'states', 'courses', 'user'));
    }

    public function choiceList()
    {
        $user = $this->getUser();
        $courses = \App\Models\Course::orderBy('name')->get(['id', 'name']);
        return view('dashboard.choice-list', compact('courses', 'user'));
    }

    public function myEnquiries()
    {
        $user = $this->getUser();
        $enquiries = \App\Models\Enquiry::where(function($q) use ($user) {
                if (isset($user->email) && $user->email) {
                    $q->where('email', $user->email);
                }
                if (isset($user->name) && $user->name) {
                    $q->orWhere('name', $user->name);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('dashboard.enquiries', compact('enquiries', 'user'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    public function profileUpdate(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
        ]);

        $updates = [
            'name' => $request->name,
            'address' => $request->address,
        ];

        // Handle phone number update with limit
        if ($request->has('phone') && $request->phone !== $user->phone) {
            $limit = 2; // Allow up to 2 updates
            if ($user->phone_updates < $limit) {
                $updates['phone'] = $request->phone;
                $updates['phone_updates'] = $user->phone_updates + 1;
            } else {
                return back()->with('error', 'You have reached the maximum limit for updating your phone number.');
            }
        }

        $user->update($updates);

        return back()->with('success', 'Profile updated successfully.');
    }
}
