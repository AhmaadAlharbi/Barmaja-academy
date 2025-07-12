<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseComment;
use App\Models\CourseContent;
use App\Models\BlogPostComment;
use App\Models\BlogPost; // Assuming you renamed the model from BlogComment to BlogPost

class DashboardController extends Controller
{
    public function index()
    {
        // Simple statistics only
        $stats = [
            'total_courses' => Course::count(),
            'published_courses' => Course::where('is_published', true)->count(),
            'total_users' => User::count(),
            'total_students' => User::where('role', '!=', 'admin')->count(),
            'total_blog_posts' => BlogPost::count(),
            'published_blog_posts' => BlogPost::where('is_published', true)->count(),
            'total_lessons' => CourseContent::count(),
            // 'total_comments' => CourseComment::count() + BlogPostComment::count(),
            'course_enrollments' => DB::table('course_user')->count(), // If you have enrollment table
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
        ]);
    }
}