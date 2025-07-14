<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContent extends Model
{
    /** @use HasFactory<\Database\Factories\CourseContentFactory> */
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'video_url',
        'sort_order',
        'is_active'
    ];

    // كل درس ينتمي لدورة
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function comments()
    {
        return $this->hasMany(CourseContentComment::class, 'course_content_id');
    }
}
