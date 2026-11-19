<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChoiceList;
use App\Models\Choice;
use App\Models\College;

class ChoiceListController extends Controller
{
    public function getActiveList()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $list = ChoiceList::firstOrCreate(
            ['user_id' => $user->id, 'is_active' => true],
            ['name' => 'My Active Preference List']
        );

        $choices = Choice::with(['college', 'course'])
            ->where('choice_list_id', $list->id)
            ->orderBy('preference_order', 'asc')
            ->get();

        return response()->json([
            'list' => $list,
            'choices' => $choices
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $colleges = College::where('college_name', 'LIKE', "%{$query}%")
            ->orWhereHas('stateRelation', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->take(10)
            ->get();

        return response()->json($colleges);
    }

    public function store(Request $request)
    {
        $request->validate([
            'list_id' => 'required|exists:choice_lists,id',
            'college_id' => 'required',
            'course_id' => 'required',
            'quota' => 'nullable|string',
            'category' => 'nullable|string',
        ]);

        $maxOrder = Choice::where('choice_list_id', $request->list_id)->max('preference_order') ?? 0;

        $choice = Choice::create([
            'choice_list_id' => $request->list_id,
            'college_id' => $request->college_id,
            'course_id' => $request->course_id,
            'quota' => $request->quota ?? 'AIQ',
            'category' => $request->category ?? 'UR',
            'preference_order' => $maxOrder + 1
        ]);

        return response()->json($choice->load(['college', 'course']));
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:choices,id',
            'orders.*.preference_order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            Choice::where('id', $item['id'])->update(['preference_order' => $item['preference_order']]);
        }

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        Choice::destroy($id);
        return response()->json(['status' => 'success']);
    }
}
