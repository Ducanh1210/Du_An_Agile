<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'excerpt',
        'content',
        'category_id',
        'author_id',
        'news_status',
        'is_featured',
        'views',
        'title_font_family',
        'title_font_size',
        'meta_title',
        'meta_description',
        'published_at',
        'tags_list',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(NewsComment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(NewsComment::class)->where('is_approved', true);
    }

    public function scopePublished($query)
    {
        return $query->where('news_status', 'published');
    }
}
