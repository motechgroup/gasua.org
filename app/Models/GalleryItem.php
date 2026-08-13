<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'media_type',
        'file_path',
        'video_url',
        'thumbnail',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
