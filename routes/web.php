<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CourseContentController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Dashboard routes
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
        Route::delete('/content/{content}', [CourseContentController::class, 'destroy'])->name('courses.content.destroy')->where(['content' => '[0-9]+']);
        Route::post('/content/{content}/toggle-active', [CourseContentController::class, 'toggleActive'])->name('courses.content.toggle-active')->where(['content' => '[0-9]+']);
    });

    Route::resource('blogs', BlogPostController::class);

    // Analytics API endpoint (for future chart integration)
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
});

// Admin-only dashboard routes (if you want admin-specific features)
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('admin.dashboard.analytics');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';