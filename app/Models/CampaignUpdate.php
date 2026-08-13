<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'title',
        'content',
        'image',
        'user_id',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
