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
    /**
     * Helper method to get translations for pages
     * Note: Locale data is already provided by HandleInertiaRequests middleware
     */
    private function getTranslationData($translationKey = 'home')
    {
        return [
            'translations' => array_merge(
                ['navbar' => trans('navbar')], // Always include navbar translations
                [$translationKey => trans($translationKey)] // Page-specific translations
            ),
        ];
    }

    public function index()
    {
        $threeCourses = Course::take(3)->get();
        $threeBlogs = BlogPost::take(3)->get();

        return Inertia::render('Welcome', array_merge([
            'threeCourses' => $threeCourses,
            'threeBlogs' => $threeBlogs,
        ], $this->getTranslationData('home')));
    }

    public function showCourses()
    {
        $courses = Course::paginate(6);

        return Inertia::render('Courses', array_merge([
            'courses' => $courses
        ], $this->getTranslationData('courses')));
    }

    public function showCourse($id)
    {
        $course = Course::with(['contents', 'comments'])->findOrFail($id);

        $user = Auth::user();            // current user or null
        $isEnrolled = false;             // default for guests

        if ($user) {
            if ($user->role === 'admin') {
                // admins always “enrolled”
                $isEnrolled = true;
            } else {
                // everyone else only if they’ve actually bought it
                $isEnrolled = $user
                    ->courses()
                    ->where('course_id', $id)
                    ->exists();
            }
        }
        return Inertia::render('Course', array_merge([
            'course' => $course,
            'isEnrolled' => $isEnrolled
        ], $this->getTranslationData('course')));
    }

    public function showBlogs()
    {
        $blogs = BlogPost::with('author')->paginate(6);

        return Inertia::render('Blogs', array_merge([
            'blogs' => $blogs
        ], $this->getTranslationData('blog')));
    }

    public function showBlog($id)
    {
        $blog = BlogPost::with('author')->findOrFail($id);

        return Inertia::render('Blog', array_merge([
            'blog' => $blog
        ], $this->getTranslationData('blog')));
    }

    public function contactUs()
    {
        return Inertia::render('Contact-us', $this->getTranslationData('contact'));
    }

    // public function showContent($course_id, $content_id = null)
    // {
    //     // Case 1: content_id is given → find content, then course
    //     if ($content_id) {
    //         $content = CourseContent::with(['comments.user'])->findOrFail($content_id);
    //         $course = Course::findOrFail($content->course_id);
    //     }
    //     // Case 2: only course_id is given → get first content
    //     else {
    //         $course = Course::findOrFail($course_id);
    //         $content = CourseContent::with(['comments.user'])
    //             ->where('course_id', $course->id)
    //             ->where('is_active', 1)
    //             ->orderBy('sort_order')
    //             ->firstOrFail();
    //     }

    //     // Check enrollment
    //     $isEnrolled = false;
    //     if (Auth::check()) {
    //         $isEnrolled = Auth::user()->courses()->where('course_id', $course->id)->exists();
    //     }

    //     // Get all lessons
    //     $allLessons = CourseContent::where('course_id', $course->id)
    //         ->where('is_active', 1)
    //         ->orderBy('sort_order')
    //         ->select('id', 'title_en', 'title_ar', 'sort_order', 'is_active', 'video_url')
    //         ->get();

    //     // Calculate progress
    //     $progress = null;
    //     if (auth()->check()) {
    //         $progress = [
    //             'total_lessons' => $allLessons->count(),
    //         ];
    //     }

    //     return Inertia::render('CourseContent', array_merge([
    //         'content' => $content,
    //         'course' => $course,
    //         'allLessons' => $allLessons,
    //         'progress' => $progress,
    //         'isEnrolled' => $isEnrolled,
    //     ], $this->getTranslationData('course')));
    // }
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
        $user = Auth::user();            // current user or null
        $isEnrolled = false;             // default for guests

        if ($user) {
            if ($user->role === 'admin') {
                // admins always “enrolled”
                $isEnrolled = true;
            } else {
                // everyone else only if they’ve actually bought it
                $isEnrolled = $user
                    ->courses()
                    ->where('course_id', $id)
                    ->exists();
            }
        }


        // Get all lessons
        $allLessons = CourseContent::where('course_id', $course->id)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->select('id', 'course_id', 'title_en', 'title_ar', 'sort_order', 'is_active', 'video_url')
            ->get();

        // Ensure video URLs are properly formatted for frontend
        if ($content->video_url && !filter_var($content->video_url, FILTER_VALIDATE_URL)) {
            $content->video_url = asset($content->video_url);
        }

        // Format all lesson video URLs
        $allLessons->transform(function ($lesson) {
            if ($lesson->video_url && !filter_var($lesson->video_url, FILTER_VALIDATE_URL)) {
                $lesson->video_url = asset($lesson->video_url);
            }
            return $lesson;
        });

        // Calculate progress
        $progress = null;
        if (auth()->check()) {
            $progress = [
                'total_lessons' => $allLessons->count(),
                'completed_lessons' => 0, // You can implement this based on your tracking system
                'percentage' => 0,
            ];
        }

        return Inertia::render('CourseContent', array_merge([
            'content' => $content,
            'course' => $course,
            'allLessons' => $allLessons,
            'progress' => $progress,
            'isEnrolled' => $isEnrolled,
        ], $this->getTranslationData('course-content')));
    }
}