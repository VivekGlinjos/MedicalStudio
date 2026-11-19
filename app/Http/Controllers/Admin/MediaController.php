<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\CollegeGallery;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // ---- VIDEOS ----
    public function videosIndex(Request $request)
    {
        $query = Video::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $videos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        return view('admin.media.videos', compact('videos'));
    }

    public function videoCreate()
    {
        return view('admin.media.video_create');
    }

    public function videoStore(Request $request)
    {
        $validated = $request->validate([
            'video_name'  => 'required|string|max:255',
            'video_link'  => 'required|string|max:500',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        }

        Video::create($validated);

        return redirect()->route('admin.media.videos')
            ->with('success', 'Video added successfully!');
    }

    public function videoEdit($id)
    {
        $video = Video::findOrFail($id);
        return view('admin.media.video_edit', compact('video'));
    }

    public function videoUpdate(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $validated = $request->validate([
            'video_name'  => 'required|string|max:255',
            'video_link'  => 'required|string|max:500',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) Storage::disk('public')->delete($video->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        }

        $video->update($validated);

        return redirect()->route('admin.media.videos')
            ->with('success', 'Video updated!');
    }

    public function videoDestroy($id)
    {
        $video = Video::findOrFail($id);
        if ($video->thumbnail) Storage::disk('public')->delete($video->thumbnail);
        $video->delete();

        return redirect()->route('admin.media.videos')
            ->with('success', 'Video deleted!');
    }

    // ---- GALLERY ----
    public function galleryIndex(Request $request)
    {
        $query = CollegeGallery::with('college');

        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }

        $galleries = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $colleges  = College::orderBy('college_name')->get(['college_id', 'college_name']);

        return view('admin.media.gallery', compact('galleries', 'colleges'));
    }

    public function galleryCreate()
    {
        $colleges = College::orderBy('college_name')->get(['college_id', 'college_name']);
        return view('admin.media.gallery_create', compact('colleges'));
    }

    public function galleryStore(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,college_id',
            'images'     => 'required|array|min:1',
            'images.*'   => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'caption'    => 'nullable|string|max:255',
        ]);

        foreach ($request->file('images') as $image) {
            $path = $image->store('gallery', 'public');
            CollegeGallery::create([
                'college_id' => $request->college_id,
                'image_path' => $path,
                'caption'    => $request->caption,
            ]);
        }

        return redirect()->route('admin.media.gallery')
            ->with('success', 'Gallery images uploaded successfully!');
    }

    public function galleryDestroy($id)
    {
        $item = CollegeGallery::findOrFail($id);
        if ($item->image_path) Storage::disk('public')->delete($item->image_path);
        $item->delete();

        return redirect()->back()->with('success', 'Gallery image deleted!');
    }
}
