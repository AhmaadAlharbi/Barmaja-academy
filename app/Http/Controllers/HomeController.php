<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Inertia\Inertia;
use App\Models\Course;
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
}