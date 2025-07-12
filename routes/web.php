<?php

use App\Http\Controllers\BlogPostController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Dashboard routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Main dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('courses', CourseController::class);
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