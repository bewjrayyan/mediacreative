<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Includes meta_* for admin SEO sidebar + public SeoManager.
     * User: pastikan masing masing ada panel meta keyword auto generated...
     */
    protected $fillable = [
        'title',
        'slug',
        'category',
        'client',
        'thumbnail',
        'gallery_images',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'technologies',
        'url',
        'is_featured',
        'status',
        'services',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'services' => 'array',
    ];

    const CATEGORIES = ['Web App', 'Website', 'Mobile', 'UI/UX', 'E-commerce'];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
    }
}
