<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\CollegeGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = College::with('galleries');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where('college_name', 'like', "%$q%")
                  ->orWhere('place', 'like', "%$q%");
        }

        $colleges = $query->orderBy('college_name')->paginate(20)->appends($request->all());

        return view('admin.galleries.index', compact('colleges'));
    }

    public function show($id)
    {
        $college = College::with('galleries')->findOrFail($id);
        return view('admin.galleries.show', compact('college'));
    }

    public function store(Request $request, $college_id)
    {
        $request->validate([
            'gallery_images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $college = College::findOrFail($college_id);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('college_galleries', 'public');
                CollegeGallery::create([
                    'college_id' => $college->college_id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Images added to gallery successfully!');
    }

    public function destroy($id)
    {
        $gallery = CollegeGallery::findOrFail($id);
        
        if (Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        
        $gallery->delete();

        return redirect()->back()->with('success', 'Image removed from gallery!');
    }
}
