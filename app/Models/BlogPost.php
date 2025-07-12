<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    /** @use HasFactory<\Database\Factories\BlogPostFactory> */
    use HasFactory;
    protected $fillable = [
        'author_id',
        'title_ar',
        'title_en',
        'slug',
        'content_ar',
        'content_en',
        'is_published',
        'published_at'
    ];

    // الكاتب (المدير)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}