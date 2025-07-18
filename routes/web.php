<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CourseContentCommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\CourseUserController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/

    // Frontend Public Routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/courses/list', [HomeController::class, 'showCourses'])->name('frontend.courses.list');
    Route::get('courses-list/{id}/course', [HomeController::class, 'showCourse'])->name('frontend.show.course');

    Route::get('/blogs/list', [HomeController::class, 'showBlogs'])->name('frontend.blogs.list');
    Route::get('blogs-list/{id}/blog', [HomeController::class, 'showBlog'])->name('frontend.show.blog');
    Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('frontend.contact-us');
    Route::get('/course/{course_id}/content/{content_id?}', [HomeController::class, 'showContent'])->name('course.content');

    // Course Content Comments (Public)
    Route::post('/course-content/comment', [CourseContentCommentController::class, 'store'])->name('comments.store');
    Route::delete('/course-content/comment/{id}', [CourseContentCommentController::class, 'destroy'])->name('comments.destroy');

    // Course Enrollment Routes
    Route::get('/enroll-course/{id}', [CourseUserController::class, 'enrollPage'])->name('enroll.page');
    Route::post('/enroll-course', [CourseUserController::class, 'enroll'])->name('course.enroll');

    // Dashboard routes (Protected by auth middleware)
    Route::middleware(['auth', 'verified'])->group(function () {
        // Main dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Course routes with numeric constraint (optional safety measure)
        Route::resource('courses', CourseController::class)->parameters([
            'courses' => 'course:id'
        ]);

        // Course Content Routes with numeric constraint
        Route::prefix('courses/{course}')->where(['course' => '[0-9]+'])->group(function () {
            Route::get('/content/create', [CourseContentController::class, 'create'])->name('courses.content.create');
            Route::post('/content', [CourseContentController::class, 'store'])->name('courses.content.store');
            Route::get('/content/{content}/edit', [CourseContentController::class, 'edit'])->name('courses.content.edit')->where(['content' => '[0-9]+']);
            Route::put('/content/{content}', [CourseContentController::class, 'update'])->name('courses.content.update')->where(['content' => '[0-9]+']);
            Route::delete('/content/{content}', [CourseContentController::class, 'destroy'])->name('courses.content.destroy')->where(['content' => '[0-9]+']);
            Route::get('/content/{content}', [CourseContentController::class, 'show'])->name('courses.content.show')->where(['content' => '[0-9]+']);
            Route::get('/content', [CourseContentController::class, 'index'])->name('courses.content.index');
            Route::post('/content/reorder', [CourseContentController::class, 'reorder'])->name('courses.content.reorder');
            Route::post('/content/{content}/toggle-active', [CourseContentController::class, 'toggleActive'])->name('courses.content.toggle-active')->where(['content' => '[0-9]+']);
        });

        // Blog routes
        Route::resource('blogs', BlogPostController::class);

        // Analytics API endpoint (for future chart integration)
        Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
    });

    // Admin-only dashboard routes (if you want admin-specific features)
    // Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    //     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    //     Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('admin.dashboard.analytics');
    // });
});

/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/
// Add any routes here that should not be localized (API routes, webhooks, etc.)

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';