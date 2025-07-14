<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseUserController extends Controller
{


    public function enrollPage($id)
    {
        $course = Course::findOrFail($id);

        $isEnrolled = false;
        if (Auth::check()) {
            // Use relationship instead of raw query
            $isEnrolled = Auth::user()->courses()->where('course_id', $id)->exists();
        }

        return Inertia::render('EnrollPage', [
            'course' => $course,
            'isEnrolled' => $isEnrolled
        ]);
    }
    public function enroll(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to enroll in courses.');
        }

        $courseId = $request->course_id;
        $user = Auth::user();

        // Validate the course exists
        $course = Course::findOrFail($courseId);

        // Check if user is already enrolled using relationship
        if ($user->courses()->where('course_id', $courseId)->exists()) {
            return redirect()->route('course.show', $course->id)
                ->with('info', 'You are already enrolled in this course!');
        }

        try {
            // Enroll the user in the course using relationship
            $user->courses()->attach($courseId);

            \Log::info('User enrolled in course', [
                'user_id' => $user->id,
                'course_id' => $courseId,
                'enrolled_at' => now()
            ]);

            return redirect()->route('course.show', $course->id)
                ->with('success', 'Congratulations! You have successfully enrolled in the course.');
        } catch (\Exception $e) {
            \Log::error('Failed to enroll user in course', [
                'user_id' => $user->id,
                'course_id' => $courseId,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to enroll in course. Please try again.');
        }
    }
}
