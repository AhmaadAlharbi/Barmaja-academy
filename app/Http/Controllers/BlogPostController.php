<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index()
    {
        $blogPosts = BlogPost::latest()
            ->paginate(10);

        return Inertia::render('Blogs/Index', [
            'blogPosts' => $blogPosts,
        ]);
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        return Inertia::render('Blogs/Create');
    }

    /**
     * Store a newly created blog post in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content_en' => 'required|string|min:50',
            'content_ar' => 'required|string|min:50',
            'is_published' => 'boolean',
        ]);

        // Generate slug from English title
        $slug = Str::slug($validated['title_en']);
        $originalSlug = $slug;
        $counter = 1;

        // Ensure unique slug
        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $blogPost = BlogPost::create([
            'title_en' => $validated['title_en'],
            'title_ar' => $validated['title_ar'],
            'slug' => $slug,
            'content_en' => $validated['content_en'],
            'content_ar' => $validated['content_ar'],
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => ($validated['is_published'] ?? false) ? now() : null,
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog post.
     */
    public function show(BlogPost $blog)
    {
        $blog->load('author:id,name');

        return Inertia::render('Blogs/Show', [
            'blogPost' => $blog,
        ]);
    }

    /**
     * Show the form for editing the specified blog post.
     */
    public function edit(BlogPost $blog)
    {
        $blog->load('author:id,name');

        return Inertia::render('Blogs/Edit', [
            'blogPost' => $blog,
        ]);
    }

    /**
     * Update the specified blog post in storage.
     */
    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content_en' => 'required|string|min:50',
            'content_ar' => 'required|string|min:50',
            'is_published' => 'boolean',
        ]);

        // Generate new slug if title changed
        if ($blog->title_en !== $validated['title_en']) {
            $slug = Str::slug($validated['title_en']);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure unique slug (excluding current blog post)
            while (BlogPost::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        // Handle published_at timestamp
        $wasPublished = $blog->is_published;
        $willBePublished = $validated['is_published'] ?? false;

        if (!$wasPublished && $willBePublished) {
            // Publishing for the first time
            $validated['published_at'] = now();
        } elseif ($wasPublished && !$willBePublished) {
            // Unpublishing
            $validated['published_at'] = null;
        }
        // If it was published and stays published, keep the original published_at

        $blog->update($validated);

        return redirect()->route('blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog post from storage.
     */
    public function destroy(BlogPost $blog)
    {
        $blog->delete();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }
}