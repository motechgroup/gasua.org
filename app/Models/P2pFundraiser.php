<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P2pFundraiser extends Model
{
    use HasFactory;

    protected $table = 'p2p_fundraisers';

    protected $fillable = [
        'user_id',
        'campaign_id',
        'title',
        'slug',
        'story',
        'goal_amount',
        'raised_amount',
        'cover_image',
        'status',
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function getProgressPercentageAttribute(): int
    {
        if ($this->goal_amount <= 0) return 0;
        $pct = ($this->raised_amount / $this->goal_amount) * 100;
        return min(100, (int) round($pct));
    }
}
