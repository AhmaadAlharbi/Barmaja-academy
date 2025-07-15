<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Models\CourseContent;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $threeCourses = Course::take(3)->get();
        $threeBlogs = BlogPost::take(3)->get();
        return Inertia::render(
            'Welcome',
            [
                'threeCourses' => $threeCourses,
                'threeBlogs' => $threeBlogs,
            ]
        );
    }
    public function showCourses()
    {
        $courses = Course::paginate(6);
        return Inertia::render(
            'Courses',
            [
                'courses' => $courses
            ]
        );
    }
    public function showCourse($id)
    {
        $course = Course::with(['contents', 'comments'])->findOrFail($id);

        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Auth::user()->courses()->where('course_id', $id)->exists();
        }

        return Inertia::render('Course', [
            'course' => $course,
            'isEnrolled' => $isEnrolled
        ]);
    }
    public function showBlogs()
    {
        $blogs = BlogPost::paginate(6);
        return Inertia::render(
            'Blogs',
            [
                'blogs' => $blogs
            ]
        );
    }
    public function showBlog($id)
    {
        $blog = BlogPost::findOrFail($id);
        return Inertia::render(
            'Blog',
            [
                'blog' => $blog
            ]
        );
    }
    public function contactUs()
    {
        return Inertia::render('Contact-us');
    }
    public function showContent($course_id, $content_id = null)
    {
        // Case 1: content_id is given → find content, then course
        if ($content_id) {
            $content = CourseContent::with(['comments.user'])->findOrFail($content_id);
            $course = Course::findOrFail($content->course_id);
        }
        // Case 2: only course_id is given → get first content
        else {
            $course = Course::findOrFail($course_id);
            $content = CourseContent::with(['comments.user'])
                ->where('course_id', $course->id)
                ->where('is_active', 1)
                ->orderBy('sort_order')
                ->firstOrFail();
        }

        // Check enrollment
        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Auth::user()->courses()->where('course_id', $course->id)->exists();
        }

        // Get all lessons
        $allLessons = CourseContent::where('course_id', $course->id)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->select('id', 'title_en', 'title_ar', 'sort_order', 'is_active', 'video_url')
            ->get();

        // Calculate progress
        $progress = null;
        if (auth()->check()) {
            $progress = [
                'total_lessons' => $allLessons->count(),
            ];
        }

        return Inertia::render('CourseContent', [
            'content' => $content,
            'course' => $course,
            'allLessons' => $allLessons,
            'progress' => $progress,
            'isEnrolled' => $isEnrolled,
        ]);
    }
}
