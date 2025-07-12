<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
    /** @use HasFactory<\Database\Factories\CourseCommentFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_id',
        'content'
    ];

    // صاحب التعليق
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الدورة التي كتب عليها التعليق
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // التعليق الأب (إن وُجد)
    // public function parent()
    // {
    //     return $this->belongsTo(self::class, 'parent_id');
    // }

    // الردود على هذا التعليق
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}