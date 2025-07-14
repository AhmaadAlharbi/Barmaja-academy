<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseContentComment>
 */
class CourseContentCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // or use existing user ID
            'course_content_id' => CourseContent::factory(), // or use existing course ID
            'comment' => $this->faker->paragraph(),
        ];
    }
}
