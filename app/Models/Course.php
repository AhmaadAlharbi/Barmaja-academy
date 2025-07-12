<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    protected $fillable = [
        'title_ar',
        'title_en',
        'slug',
        'description_ar',
        'description_en',
        'price',
        'preview_video_url',
        'is_published'
    ];
    // الدورات مفتوحة للمستخدمين الذين اشتروها
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
    public function contents()
    {
        return $this->hasMany(CourseContent::class)
            ->orderBy('sort_order');
    }
    public function comments()
    {
        return $this->hasMany(CourseComment::class);
    }
}