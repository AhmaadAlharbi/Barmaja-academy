<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = ['name', 'email', 'password', 'role', 'preferred_language'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function courses()
    // {
    //     return $this->belongsToMany(Course::class)
    //         ->withTimestamps();
    // }
    public function courses()
    {
        return $this->belongsToMany(Course::class)
            ->withPivot(['enrolled_at', 'payment_method', 'amount_paid', 'status'])
            ->withTimestamps();
    }
    // التعليقات التي كتبها المستخدم
    public function comments()
    {
        return $this->hasMany(CourseComment::class);
    }

    // المقالات التي نشرها كمدير
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
}
