<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $query = State::withCount('colleges');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sortBy  = $request->get('sort_by', 'name');
        $sortDir = $request->get('sort_dir', 'asc');

        $states = $query->orderBy($sortBy, $sortDir)->paginate(20)->withQueryString();

        return view('admin.states.index', compact('states'));
    }

    public function create()
    {
        return view('admin.states.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:states,name',
            'code'        => 'nullable|string|max:10',
            'region'      => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('states', 'public');
        }

        State::create($validated);

        return redirect()->route('admin.states.index')
            ->with('success', 'State added successfully!');
    }

    public function edit($id)
    {
        $state = State::findOrFail($id);
        return view('admin.states.edit', compact('state'));
    }

    public function update(Request $request, $id)
    {
        $state = State::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:states,name,' . $id,
            'code'        => 'nullable|string|max:10',
            'region'      => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($state->cover_image) Storage::disk('public')->delete($state->cover_image);
            $validated['cover_image'] = $request->file('cover_image')
                ->store('states', 'public');
        }

        $state->update($validated);

        return redirect()->route('admin.states.index')
            ->with('success', 'State updated successfully!');
    }

    public function destroy($id)
    {
        $state = State::findOrFail($id);

        if ($state->cover_image) Storage::disk('public')->delete($state->cover_image);

        $state->delete();

        return redirect()->route('admin.states.index')
            ->with('success', 'State deleted!');
    }
}
