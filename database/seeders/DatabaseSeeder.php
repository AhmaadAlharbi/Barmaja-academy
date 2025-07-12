<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\BlogPost;
use App\Models\CourseComment;
use App\Models\CourseContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Ahmad Z',
            'email' => 'ahmaadzaid7@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'Yousef A',
            'email' => 'yousef@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'student'
        ]);

        // Create courses
        Course::factory(10)->create();

        // Get all courses and create content for each
        $courses = Course::all();
        foreach ($courses as $course) {
            $lessonCount = rand(5, 12);

            // Create lessons with proper ordering
            for ($i = 1; $i <= $lessonCount; $i++) {
                CourseContent::factory()
                    ->forCourse($course->id)
                    ->create([
                        'sort_order' => $i,
                    ]);
            }
        }

        $this->command->info('Created ' . Course::count() . ' courses');
        $this->command->info('Created ' . CourseContent::count() . ' course contents');

        CourseComment::factory(20)->create();
        BlogPost::factory(20)->create();
    }
}