<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway_code',
        'event_type',
        'payload',
        'status',
        'retry_count',
        'error_message',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
