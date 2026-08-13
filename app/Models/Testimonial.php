<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role_description',
        'photo',
        'quote',
        'video_url',
        'is_featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
