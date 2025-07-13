<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CourseContentController extends Controller
{
    /**
     * Show the form for creating new course content.
     */
    public function create($course)
    {
        $course = Course::findOrFail($course);

        return Inertia::render('CourseContent/Create', [
            'course' => $course
        ]);
    }

    /**
     * Store a newly created course content in storage.
     */
    public function store(Request $request, $course)
    {
        // Verify course exists and get the model
        $course = Course::findOrFail($course);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'video_url' => 'nullable|url|max:500',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ], [
            'title_en.required' => 'English title is required',
            'title_ar.required' => 'Arabic title is required',
            'content_en.required' => 'English content is required',
            'content_ar.required' => 'Arabic content is required',
            'video_url.url' => 'Video URL must be a valid URL',
            'sort_order.required' => 'Lesson order is required',
            'sort_order.min' => 'Lesson order must be at least 1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if sort_order already exists for this course using relationship
        $existingContent = $course->contents()
            ->where('sort_order', $request->sort_order)
            ->first();

        if ($existingContent) {
            return back()->withErrors([
                'sort_order' => 'A lesson with this order already exists. Please choose a different order.'
            ])->withInput();
        }

        try {
            // Create the course content using relationship
            $courseContent = $course->contents()->create([
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'content_en' => $request->content_en,
                'content_ar' => $request->content_ar,
                'video_url' => $request->video_url,
                'sort_order' => $request->sort_order,
                'is_active' => $request->boolean('is_active', true)
            ]);

            return redirect()
                ->route('courses.show', $course->id)
                ->with('success', 'Course content created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to create course content. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified course content.
     */
    public function edit($course, $content)
    {
        // Option 1: Fetch course first, then use relationship (more secure)
        $course = Course::findOrFail($course);
        $content = $course->contents()->findOrFail($content);

        return Inertia::render('CourseContent/Edit', [
            'course' => $course,
            'content' => $content
        ]);
    }

    /**
     * Update the specified course content in storage.
     */
    public function update(Request $request, $course, $content)
    {
        // Verify course and content exist using relationships
        $course = Course::findOrFail($course);
        $content = $course->contents()->findOrFail($content);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'video_url' => 'nullable|url|max:500',
            'sort_order' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ], [
            'title_en.required' => 'English title is required',
            'title_ar.required' => 'Arabic title is required',
            'content_en.required' => 'English content is required',
            'content_ar.required' => 'Arabic content is required',
            'video_url.url' => 'Video URL must be a valid URL',
            'sort_order.required' => 'Lesson order is required',
            'sort_order.min' => 'Lesson order must be at least 1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if sort_order already exists for this course (excluding current content)
        $existingContent = $course->contents()
            ->where('sort_order', $request->sort_order)
            ->where('id', '!=', $content->id)
            ->first();

        if ($existingContent) {
            return back()->withErrors([
                'sort_order' => 'A lesson with this order already exists. Please choose a different order.'
            ])->withInput();
        }

        try {
            // Update the course content
            $content->update([
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'content_en' => $request->content_en,
                'content_ar' => $request->content_ar,
                'video_url' => $request->video_url,
                'sort_order' => $request->sort_order,
                'is_active' => $request->boolean('is_active', true)
            ]);

            return redirect()
                ->route('courses.show', $course->id)
                ->with('success', 'Course content updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to update course content. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified course content from storage.
     */
    public function destroy($course, $content)
    {
        try {
            $course = Course::findOrFail($course);
            $content = $course->courseContents()->findOrFail($content);

            $content->delete();

            return redirect()
                ->route('courses.show', $course->id)
                ->with('success', 'Course content deleted successfully!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete course content. Please try again.');
        }
    }

    /**
     * Display the specified course content.
     */
    public function show($course, $content)
    {
        $course = Course::findOrFail($course);
        $content = $course->contents()->findOrFail($content);

        return Inertia::render('CourseContent/Show', [
            'course' => $course,
            'content' => $content
        ]);
    }

    /**
     * Get all content for a specific course (for API or AJAX requests)
     */
    public function index($course)
    {
        $course = Course::findOrFail($course);
        $contents = $course->contents()->orderBy('sort_order')->get();

        return response()->json([
            'course' => $course,
            'contents' => $contents
        ]);
    }

    /**
     * Reorder course content
     */
    public function reorder(Request $request, $course)
    {
        $course = Course::findOrFail($course);

        $validator = Validator::make($request->all(), [
            'content_orders' => 'required|array',
            'content_orders.*.id' => 'required|exists:course_contents,id',
            'content_orders.*.sort_order' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            foreach ($request->content_orders as $order) {
                $course->contents()
                    ->where('id', $order['id'])
                    ->update(['sort_order' => $order['sort_order']]);
            }

            return response()->json(['message' => 'Content reordered successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reorder content'], 500);
        }
    }

    /**
     * Toggle the active status of course content
     */
    public function toggleActive($course, $content)
    {
        try {
            $course = Course::findOrFail($course);
            $content = $course->contents()->findOrFail($content);

            // Toggle the is_active status
            $newStatus = !$content->is_active;
            $content->update(['is_active' => $newStatus]);

            $status = $newStatus ? 'activated' : 'deactivated';
            $message = "Course content \"{$content->title_en}\" has been {$status} successfully!";

            return redirect()
                ->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update content status. Please try again.');
        }
    }
}