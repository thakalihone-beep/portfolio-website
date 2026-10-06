<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'subject',
        'semester',
        'course',
        'description',
        'content',
        'tags',
        'cover_image',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
