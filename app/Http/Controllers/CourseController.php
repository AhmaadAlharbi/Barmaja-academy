<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::latest()
            ->paginate(10);

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
        ]);
    }


    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return Inertia::render('Courses/Create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string|min:10',
            'description_ar' => 'required|string|min:10',
            'price' => 'required|numeric|min:0|max:999999.99',
            'preview_video_url' => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        // Generate slug from English title
        $slug = Str::slug($validated['title_en']);
        $originalSlug = $slug;
        $counter = 1;

        // Ensure unique slug
        while (Course::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $course = Course::create([
            'title_en' => $validated['title_en'],
            'title_ar' => $validated['title_ar'],
            'slug' => $slug,
            'description_en' => $validated['description_en'],
            'description_ar' => $validated['description_ar'],
            'price' => $validated['price'],
            'preview_video_url' => $validated['preview_video_url'],
            'is_published' => $validated['is_published'] ?? false,
            'author_id' => auth()->id(), // Assuming you have author_id in your courses table
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load(['contents' => function ($query) {
            $query->orderBy('sort_order');
        }]);

        return Inertia::render('Courses/Show', [
            'course' => $course,
        ]);
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        return Inertia::render('Courses/Edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string|min:10',
            'description_ar' => 'required|string|min:10',
            'price' => 'required|numeric|min:0|max:999999.99',
            'preview_video_url' => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        // Generate new slug if title changed
        if ($course->title_en !== $validated['title_en']) {
            $slug = Str::slug($validated['title_en']);
            $originalSlug = $slug;
            $counter = 1;

            // Ensure unique slug (excluding current course)
            while (Course::where('slug', $slug)->where('id', '!=', $course->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}