<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'bio',
        'achievements',
        'photos',
        'video_url',
        'profile_image',
        'target_amount',
        'raised_amount',
        'sponsor_info',
        'is_featured',
    ];

    protected $casts = [
        'achievements' => 'array',
        'photos' => 'array',
        'target_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
