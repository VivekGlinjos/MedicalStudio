<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('name', 'like', "%$q%");
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $courses = $query->orderBy($sortBy, $sortDir)->paginate(15)->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'level'                 => 'required|in:UG,PG',
            'duration'              => 'nullable|string|max:50',
            'short_note'            => 'nullable|string',
            'description'           => 'nullable|string',
            'admission_requirements'=> 'nullable|string',
            'seo_text'              => 'nullable|string',
            'image'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'banner'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('courses', 'public');
        }

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('courses', 'public');
        }

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course added successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'level'                 => 'required|in:UG,PG',
            'duration'              => 'nullable|string|max:50',
            'short_note'            => 'nullable|string',
            'description'           => 'nullable|string',
            'admission_requirements'=> 'nullable|string',
            'seo_text'              => 'nullable|string',
            'image'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'banner'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($course->image) Storage::disk('public')->delete($course->image);
            $validated['image'] = $request->file('image')->store('courses', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($course->banner) Storage::disk('public')->delete($course->banner);
            $validated['banner'] = $request->file('banner')->store('courses', 'public');
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        if ($course->image) Storage::disk('public')->delete($course->image);
        if ($course->banner) Storage::disk('public')->delete($course->banner);

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted!');
    }

    public function toggleStatus($id)
    {
        $course = Course::findOrFail($id);
        $course->is_active = $course->is_active ? 0 : 1;
        $course->save();

        $status = $course->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Course {$status} successfully!");
    }
}
