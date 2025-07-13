<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\Request;

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
        return Inertia::render(
            'Course',
            [
                'course' => $course
            ]
        );
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
    public function showContent($content_id)
    {
        $content = CourseContent::findOrFail($content_id);

        // Get the course information
        $course = Course::findOrFail($content->course_id);

        // Get all lessons for this course (for navigation)
        $allLessons = CourseContent::where('course_id', $content->course_id)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->select('id', 'title_en', 'title_ar', 'sort_order', 'is_active', 'video_url')
            ->get();

        // Optional: Get user progress if you have user authentication
        $progress = null;
        if (auth()->check()) {
            // Calculate user progress
            $totalLessons = $allLessons->count();
            $completedLessons = 0; // You'd get this from a user_progress table
            $progress = [
                'completed_lessons' => $completedLessons,
                'total_lessons' => $totalLessons,
                'percentage' => $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0
            ];
        }

        return Inertia::render('CourseContent', [
            'content' => $content,
            'course' => $course,
            'allLessons' => $allLessons,
            'progress' => $progress
        ]);
    }
}
