<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Blog index — list all published posts
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        $posts = BlogPost::published()
            ->when($category, fn($q) => $q->where('category', $category))
            ->latest('published_at')
            ->paginate(9);

        $categories = BlogPost::published()
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('blog.index', compact('posts', 'categories', 'category'));
    }

    /**
     * Single blog post
     */
    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'related'));
    }
}
