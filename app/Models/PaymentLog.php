<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'gateway_code',
        'request_payload',
        'response_payload',
        'ip_address',
        'status',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
