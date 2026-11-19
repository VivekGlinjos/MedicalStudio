<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\State;
use App\Http\Requests\StoreCollegeRequest;
use App\Http\Requests\UpdateCollegeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CollegeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = College::with('stateRelation');

        if ($request->has('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->has('college_type')) {
            $query->where('college_type', $request->college_type);
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->boolean('active', true)) {
            $query->active();
        }

        $perPage = $request->get('per_page', 15);
        $colleges = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $colleges->items(),
            'pagination' => [
                'total' => $colleges->total(),
                'per_page' => $colleges->perPage(),
                'current_page' => $colleges->currentPage(),
                'last_page' => $colleges->lastPage(),
            ]
        ]);
    }

    public function show($id): JsonResponse
    {
        $college = College::with(['stateRelation', 'galleries', 'cutoffs', 'seatMatrices'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $college,
        ]);
    }

    public function showBySlug($slug): JsonResponse
    {
        $college = College::where('slug', $slug)
            ->with(['stateRelation', 'galleries', 'cutoffs', 'seatMatrices'])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $college,
        ]);
    }

    public function store(StoreCollegeRequest $request): JsonResponse
    {
        $college = College::create($request->validated());
        $college->load('stateRelation');

        return response()->json([
            'success' => true,
            'message' => 'College created successfully',
            'data' => $college,
        ], 201);
    }

    public function update(UpdateCollegeRequest $request, $id): JsonResponse
    {
        $college = College::findOrFail($id);
        $college->update($request->validated());
        $college->load('stateRelation');

        return response()->json([
            'success' => true,
            'message' => 'College updated successfully',
            'data' => $college,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $college = College::findOrFail($id);
        $college->delete();

        return response()->json([
            'success' => true,
            'message' => 'College deleted successfully',
        ]);
    }

    public function getByState($stateId): JsonResponse
    {
        $state = State::findOrFail($stateId);
        $colleges = $state->colleges()->paginate(15);

        return response()->json([
            'success' => true,
            'state' => $state->only(['id', 'name', 'code']),
            'colleges' => $colleges->items(),
            'pagination' => [
                'total' => $colleges->total(),
                'per_page' => $colleges->perPage(),
                'current_page' => $colleges->currentPage(),
            ]
        ]);
    }

    public function getByType($type): JsonResponse
    {
        $colleges = College::where('college_type', $type)
            ->with('stateRelation')
            ->active()
            ->paginate(15);

        $typeLabel = match((int)$type) {
            0 => 'Government',
            1 => 'Private',
            2 => 'Deemed',
            default => 'Unknown',
        };

        return response()->json([
            'success' => true,
            'type' => $typeLabel,
            'colleges' => $colleges->items(),
            'pagination' => [
                'total' => $colleges->total(),
                'per_page' => $colleges->perPage(),
                'current_page' => $colleges->currentPage(),
            ]
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->get('q', '');

        if (strlen($search) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Search query must be at least 2 characters',
            ], 400);
        }

        $colleges = College::search($search)
            ->with('stateRelation')
            ->active()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'search_query' => $search,
            'results' => $colleges->items(),
            'count' => $colleges->total(),
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_colleges' => College::count(),
                'active_colleges' => College::active()->count(),
                'government_colleges' => College::where('college_type', 0)->count(),
                'private_colleges' => College::where('college_type', 1)->count(),
                'deemed_colleges' => College::where('college_type', 2)->count(),
                'total_states' => State::count(),
                'total_seats' => College::sum('total_seats') ?? 0,
            ]
        ]);
    }
}
