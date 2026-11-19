<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;
use App\Models\State;

class SeatPredictorController extends Controller
{
    public function index()
    {
        $states = State::orderBy('name')->get();
        return view('seat-predictor', compact('states'));
    }

    /**
     * Returns categorized college prediction results.
     *
     * Algorithm:
     * 1. Map user category to the relevant rank column
     * 2. Filter by counselling type (AIQ/State/Deemed/Central)
     * 3. For State Quota: only show colleges in user's domicile state
     * 4. Classify results into High Chance / Borderline / Low Chance
     *    using a 10% buffer around the historical closing rank
     */
    public function calculate(Request $request)
    {
        $rank       = (int) $request->input('rank', 0);
        $category   = strtoupper($request->input('category', 'UR'));
        $quota      = $request->input('quota', 'all');
        $exam       = $request->input('exam', 'neet-ug');
        $stateId    = $request->input('state_id');

        if ($rank <= 0) {
            return response()->json([
                'count'      => 0,
                'high_chance' => 0,
                'borderline'  => 0,
                'low_chance'  => 0,
            ]);
        }

        // Build the base query based on category
        $query = College::query();
        if ($category === 'OBC') {
            $query->where('obc_rank', '>', 0);
        } elseif ($category === 'SC') {
            $query->where('sc_rank', '>', 0);
        } elseif ($category === 'ST') {
            $query->where('st_rank', '>', 0);
        } else {
            // For GEN, EW, MU, EZ, etc., fallback to general_rank
            $query->where('general_rank', '>', 0);
        }

        // Apply counselling/quota filter
        switch ($quota) {
            case 'aiq':
                // All India Quota: all govt + central colleges across India
                $query->whereIn('college_type', [0, 3]);
                break;

            case 'state':
                // State Quota: only colleges in the user's domicile state
                if ($stateId) {
                    $query->where('state_id', $stateId);
                }
                // State quota applies to govt colleges
                $query->where('college_type', 0);
                break;

            case 'deemed':
                // Deemed Universities: 100% through centralized counselling
                $query->where('college_type', 2);
                break;

            case 'central':
                // Central Universities (AIIMS, BHU, AMU, JIPMER, etc.)
                $query->where('college_type', 3);
                break;

            case 'all':
            default:
                // All quotas — no type filter, but apply state filter if provided
                // for state quota subset
                break;
        }

        // Fetch all matching colleges
        $colleges = $query->get();

        // Classify into 3 tiers
        $highChance  = [];
        $borderline  = [];
        $lowChance   = [];

        foreach ($colleges as $college) {
            // Map category to the right rank column
            $closingRank = 0;
            if ($category === 'OBC') {
                $closingRank = $college->obc_rank;
            } elseif ($category === 'SC') {
                $closingRank = $college->sc_rank;
            } elseif ($category === 'ST') {
                $closingRank = $college->st_rank;
            } else {
                // Fallback for GEN, EW, MU, EZ, etc.
                $closingRank = $college->general_rank;
            }
            
            if ($closingRank <= 0) continue;

            // 10% buffer to account for year-over-year rank volatility
            $buffer = $closingRank * 0.10;
            $rankDifference = $closingRank - $rank;

            if ($rankDifference > $buffer) {
                // User rank is significantly better (lower number) than closing rank
                $highChance[] = [
                    'id'     => $college->college_id,
                    'name'   => $college->college_name,
                    'state'  => $college->state ?? ($college->stateRelation->name ?? ''),
                    'type'   => $college->getTypeLabel(),
                    'fees'   => $college->college_fees,
                    'rank'   => $closingRank,
                    'seats'  => $college->total_seats,
                ];
            } elseif ($rankDifference >= -$buffer) {
                // User rank is close to the historical closing rank
                $borderline[] = [
                    'id'     => $college->college_id,
                    'name'   => $college->college_name,
                    'state'  => $college->state ?? ($college->stateRelation->name ?? ''),
                    'type'   => $college->getTypeLabel(),
                    'fees'   => $college->college_fees,
                    'rank'   => $closingRank,
                    'seats'  => $college->total_seats,
                ];
            } else {
                // User rank is worse (higher number) than closing rank
                $lowChance[] = [
                    'id'     => $college->college_id,
                    'name'   => $college->college_name,
                    'state'  => $college->state ?? ($college->stateRelation->name ?? ''),
                    'type'   => $college->getTypeLabel(),
                    'fees'   => $college->college_fees,
                    'rank'   => $closingRank,
                    'seats'  => $college->total_seats,
                ];
            }
        }

        // Sort each tier by closing rank (ascending = best colleges first)
        usort($highChance, fn($a, $b) => $a['rank'] <=> $b['rank']);
        usort($borderline, fn($a, $b) => $a['rank'] <=> $b['rank']);
        usort($lowChance,  fn($a, $b) => $a['rank'] <=> $b['rank']);

        $totalCount = count($highChance) + count($borderline) + count($lowChance);

        return response()->json([
            'count'        => $totalCount,
            'high_chance'  => count($highChance),
            'borderline'   => count($borderline),
            'low_chance'   => count($lowChance),
            // Only send top results for the free teaser preview
            'preview'      => array_slice($highChance, 0, 5),
        ]);
    }
}
