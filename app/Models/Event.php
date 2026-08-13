<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'event_date',
        'start_time',
        'end_time',
        'location_name',
        'address',
        'latitude',
        'longitude',
        'ticket_price',
        'max_participants',
        'registered_count',
        'goal_amount',
        'raised_amount',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'ticket_price' => 'decimal:2',
        'goal_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'event_volunteers')->withPivot('assigned_role')->withTimestamps();
    }
}
