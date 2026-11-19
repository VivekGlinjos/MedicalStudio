<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\State;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CollegeController extends Controller
{
    public function index(Request $request)
    {
        $query = College::with('stateRelation');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qr) use ($q) {
                $qr->where('college_name', 'like', "%$q%")
                   ->orWhere('place', 'like', "%$q%");
            });
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->filled('college_type')) {
            $query->where('college_type', $request->college_type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $allowedSorts = ['college_name', 'place', 'created_at', 'college_type', 'is_active'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';

        $colleges = $query->orderBy($sortBy, $sortDir)->paginate(50)->appends($request->all());
        $states   = State::orderBy('name')->get();

        return view('admin.colleges.index', compact('colleges', 'states'));
    }

    public function create()
    {
        $states  = State::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.colleges.create', compact('states', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'college_name'       => 'required|string|max:255',
            'state_id'           => 'required|exists:states,id',
            'college_type'       => 'required|in:0,1,2,3',
            'place'              => 'required|string|max:255',
            'city'               => 'nullable|string|max:255',
            'about_us'           => 'nullable|string',
            'college_description'=> 'nullable|string',
            'courses'            => 'nullable|string',
            'year_of_inspection' => 'nullable|string|max:10',
            'total_seats'        => 'nullable|integer',
            'hospital_beds'      => 'nullable|integer',
            'college_fees'       => 'nullable|string|max:100',
            'website_link'       => 'nullable|url|max:255',
            'remarks'            => 'nullable|string',
            'general_rank'       => 'nullable|integer',
            'obc_rank'           => 'nullable|integer',
            'sc_rank'            => 'nullable|integer',
            'st_rank'            => 'nullable|integer',
            'cutoff_year'        => 'nullable|integer',
            'seo_text'           => 'nullable|string',
            'college_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'college_banner'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'gallery_images.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'dean_email'         => 'nullable|email|max:255',
            'dean_contact'       => 'nullable|string|max:255',
            'principal_email'    => 'nullable|email|max:255',
            'principal_contact'  => 'nullable|string|max:255',
            'nodal_email'        => 'nullable|email|max:255',
            'nodal_contact'      => 'nullable|string|max:255',
            'extra_image_1'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'extra_image_2'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'extra_image_3'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $validated['slug']       = Str::slug($validated['college_name']);
        $validated['is_active']  = $request->has('is_active') ? 1 : 0;
        $validated['created_by'] = auth()->id();

        // Handle image uploads
        if ($request->hasFile('college_image')) {
            $validated['college_image'] = $request->file('college_image')
                ->store('colleges', 'public');
        }

        if ($request->hasFile('college_banner')) {
            $validated['college_banner'] = $request->file('college_banner')
                ->store('colleges', 'public');
        }

        foreach (['extra_image_1', 'extra_image_2', 'extra_image_3'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('colleges', 'public');
            }
        }

        $college = College::create($validated);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('college_galleries', 'public');
                \App\Models\CollegeGallery::create([
                    'college_id' => $college->college_id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College added successfully!');
    }

    public function edit($id)
    {
        $college = College::findOrFail($id);
        $states  = State::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();
        return view('admin.colleges.edit', compact('college', 'states', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $college = College::findOrFail($id);

        $validated = $request->validate([
            'college_name'       => 'required|string|max:255',
            'state_id'           => 'required|exists:states,id',
            'college_type'       => 'required|in:0,1,2,3',
            'place'              => 'required|string|max:255',
            'city'               => 'nullable|string|max:255',
            'about_us'           => 'nullable|string',
            'college_description'=> 'nullable|string',
            'courses'            => 'nullable|string',
            'year_of_inspection' => 'nullable|string|max:10',
            'total_seats'        => 'nullable|integer',
            'hospital_beds'      => 'nullable|integer',
            'college_fees'       => 'nullable|string|max:100',
            'website_link'       => 'nullable|url|max:255',
            'remarks'            => 'nullable|string',
            'general_rank'       => 'nullable|integer',
            'obc_rank'           => 'nullable|integer',
            'sc_rank'            => 'nullable|integer',
            'st_rank'            => 'nullable|integer',
            'cutoff_year'        => 'nullable|integer',
            'seo_text'           => 'nullable|string',
            'college_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'college_banner'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'gallery_images.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'dean_email'         => 'nullable|email|max:255',
            'dean_contact'       => 'nullable|string|max:255',
            'principal_email'    => 'nullable|email|max:255',
            'principal_contact'  => 'nullable|string|max:255',
            'nodal_email'        => 'nullable|email|max:255',
            'nodal_contact'      => 'nullable|string|max:255',
            'extra_image_1'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'extra_image_2'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'extra_image_3'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $validated['updated_by'] = auth()->id();
        $validated['is_active']  = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('college_image')) {
            if ($college->college_image) {
                Storage::disk('public')->delete($college->college_image);
            }
            $validated['college_image'] = $request->file('college_image')
                ->store('colleges', 'public');
        }

        if ($request->hasFile('college_banner')) {
            if ($college->college_banner) {
                Storage::disk('public')->delete($college->college_banner);
            }
            $validated['college_banner'] = $request->file('college_banner')
                ->store('colleges', 'public');
        }

        foreach (['extra_image_1', 'extra_image_2', 'extra_image_3'] as $field) {
            if ($request->hasFile($field)) {
                if ($college->$field) {
                    Storage::disk('public')->delete($college->$field);
                }
                $validated[$field] = $request->file($field)->store('colleges', 'public');
            }
        }

        $college->update($validated);

        if ($request->has('delete_galleries')) {
            $deleteIds = $request->input('delete_galleries');
            $galleriesToDelete = \App\Models\CollegeGallery::whereIn('id', $deleteIds)->get();
            foreach ($galleriesToDelete as $g) {
                Storage::disk('public')->delete($g->image_path);
                $g->delete();
            }
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('college_galleries', 'public');
                \App\Models\CollegeGallery::create([
                    'college_id' => $college->college_id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College updated successfully!');
    }

    public function destroy($id)
    {
        $college = College::findOrFail($id);

        if ($college->college_image) Storage::disk('public')->delete($college->college_image);
        if ($college->college_banner) Storage::disk('public')->delete($college->college_banner);

        foreach ($college->galleries as $gallery) {
            Storage::disk('public')->delete($gallery->image_path);
            $gallery->delete();
        }

        $college->delete();

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College deleted!');
    }

    public function toggleStatus($id)
    {
        $college = College::findOrFail($id);
        $college->is_active = $college->is_active == 0 ? 1 : 0;
        $college->save();

        $status = $college->is_active == 1 ? 'deactivated' : 'activated';
        return redirect()->back()->with('success', "College {$status} successfully!");
    }
}
