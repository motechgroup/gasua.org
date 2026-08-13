<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'cover_image',
        'gallery_images',
        'goal_amount',
        'raised_amount',
        'donors_count',
        'start_date',
        'end_date',
        'category',
        'status',
        'is_featured',
        'is_emergency',
        'meta_title',
        'meta_description',
        'created_by',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'goal_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'is_emergency' => 'boolean',
    ];

    public function updates()
    {
        return $this->hasMany(CampaignUpdate::class)->latest();
    }

    public function comments()
    {
        return $this->hasMany(CampaignComment::class)->latest();
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function p2pFundraisers()
    {
        return $this->hasMany(P2pFundraiser::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getProgressPercentageAttribute(): int
    {
        if ($this->goal_amount <= 0) return 0;
        $pct = ($this->raised_amount / $this->goal_amount) * 100;
        return min(100, (int) round($pct));
    }
}
