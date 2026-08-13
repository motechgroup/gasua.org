<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_reference',
        'user_id',
        'campaign_id',
        'p2p_fundraiser_id',
        'talent_id',
        'amount',
        'currency',
        'net_amount',
        'fee_amount',
        'donor_name',
        'donor_email',
        'donor_phone',
        'donor_country',
        'donor_message',
        'is_anonymous',
        'is_recurring',
        'recurring_frequency',
        'donation_type',
        'dedication_name',
        'dedication_message',
        'payment_gateway_id',
        'gateway_code',
        'payment_status',
        'payment_reference',
        'receipt_number',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'is_recurring' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function p2pFundraiser()
    {
        return $this->belongsTo(P2pFundraiser::class);
    }

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function paymentLogs()
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function receipt()
    {
        return $this->hasOne(DonationReceipt::class);
    }
}
