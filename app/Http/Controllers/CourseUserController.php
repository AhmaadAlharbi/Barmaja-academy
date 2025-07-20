<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CourseUserController extends Controller
{
    // public function enrollPage($id)
    // {
    //     $course = Course::findOrFail($id);
    //     $isEnrolled = false;

    //     if (Auth::check()) {
    //         $isEnrolled = Auth::user()->courses()->where('course_id', $id)->exists();
    //     }

    //     return Inertia::render('EnrollPage', [
    //         'stripeKey' => env('STRIPE_KEY'),
    //         'setupIntent' => auth()->user() ? auth()->user()->createSetupIntent() : null,
    //         'course' => $course,
    //         'isEnrolled' => $isEnrolled
    //     ]);
    // }
    public function enrollPage($id)
    {
        $course = Course::findOrFail($id);
        $isEnrolled = false;

        if (Auth::check()) {
            $isEnrolled = Auth::user()->courses()->where('course_id', $id)->exists();
        }

        return Inertia::render('EnrollPage', [
            'stripeKey' => env('STRIPE_KEY'),
            'setupIntent' => auth()->user() ? auth()->user()->createSetupIntent() : null,
            'course' => $course,
            'isEnrolled' => $isEnrolled,
            // Add translations
            'translations' => [
                'enroll' => __('enroll'),
                'validation' => __('validation'), // For form validation messages
            ],
            // Add current locale for component
            'currentLocale' => app()->getLocale(),
        ]);
    }
    public function enroll(Request $request)
    {
        // 1. CHECK: Is user logged in?
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // 2. VALIDATE: Make sure we have all required data
        $request->validate([
            'course_id' => 'required',
            'payment_method' => 'required',
            'cardholder_name' => 'required',
            'email' => 'required|email'
        ]);

        // 3. GET: User and Course
        $user = Auth::user();
        $course = Course::findOrFail($request->course_id);
        $paymentMethod = $request->payment_method;

        // 4. CHECK: Already enrolled?
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'You already own this course!');
        }

        // 5. STRIPE PAYMENT: Charge the user
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $user->createOrGetStripeCustomer();

            \Stripe\PaymentIntent::create([
                'amount' => $course->price * 100,  // $50 = 5000 cents
                'currency' => 'usd',
                'customer' => $user->stripe_id,
                'payment_method' => $paymentMethod,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ]
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }

        // 6. SUCCESS: Add user to course
        $user->courses()->attach($course->id, [
            'enrolled_at' => now(),
            'payment_method' => $paymentMethod,
            'amount_paid' => $course->price,
            'status' => 'active'
        ]);

        // 7. REDIRECT: Go to course
        return redirect()->route('course.content', $course->id)
            ->with('success', 'Successfully enrolled in the course!');
    }
}