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
}