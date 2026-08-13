<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'receipt_number',
        'pdf_path',
        'qr_code_hash',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
