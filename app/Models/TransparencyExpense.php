<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransparencyExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'campaign_id',
        'amount',
        'expense_date',
        'description',
        'proof_document',
        'category',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
