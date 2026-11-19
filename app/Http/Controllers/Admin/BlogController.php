<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qr) use ($q) {
                $qr->where('title', 'like', "%$q%")
                   ->orWhere('category', 'like', "%$q%")
                   ->orWhere('author', 'like', "%$q%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('published')) {
            $query->where('published', $request->published);
        }

        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $blogs      = $query->orderBy($sortBy, $sortDir)->paginate(15)->withQueryString();
        $categories = BlogPost::distinct()->pluck('category')->filter()->values();

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'author'       => 'nullable|string|max:100',
            'tags'         => 'nullable|string|max:255',
            'seo_text'     => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'published'    => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug']      = Str::slug($validated['title']);
        $validated['published'] = $request->has('published') ? 1 : 0;
        $validated['author']    = $validated['author'] ?? auth()->user()->name;
        if (empty($validated['published_at']) && $validated['published']) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit($id)
    {
        $blog = BlogPost::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = BlogPost::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'author'       => 'nullable|string|max:100',
            'tags'         => 'nullable|string|max:255',
            'seo_text'     => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'published'    => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['published'] = $request->has('published') ? 1 : 0;
        if (empty($validated['published_at']) && $validated['published'] && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            if ($blog->image) Storage::disk('public')->delete($blog->image);
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy($id)
    {
        $blog = BlogPost::findOrFail($id);
        if ($blog->image) Storage::disk('public')->delete($blog->image);
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted!');
    }

    public function togglePublish($id)
    {
        $blog = BlogPost::findOrFail($id);
        $blog->published = !$blog->published;
        if ($blog->published && !$blog->published_at) {
            $blog->published_at = now();
        }
        $blog->save();

        $status = $blog->published ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Blog post {$status}!");
    }
}
