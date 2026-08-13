<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'county',
        'address',
        'skills',
        'availability',
        'motivation',
        'status',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'skills' => 'array',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_volunteers')->withPivot('assigned_role')->withTimestamps();
    }
}
