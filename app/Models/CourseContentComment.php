<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContentComment extends Model
{
    /** @use HasFactory<\Database\Factories\CourseContentCommentFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'course_content_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
