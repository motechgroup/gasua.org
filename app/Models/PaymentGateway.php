<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_enabled',
        'is_test_mode',
        'is_default',
        'credentials',
        'instructions',
        'fee_percentage',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_test_mode' => 'boolean',
        'is_default' => 'boolean',
        'fee_percentage' => 'decimal:2',
    ];

    public function setCredentialsAttribute($value)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }
        $this->attributes['credentials'] = !empty($value) ? Crypt::encryptString($value) : null;
    }

    public function getCredentialsAttribute($value)
    {
        if (empty($value)) return [];
        try {
            $decrypted = Crypt::decryptString($value);
            return json_decode($decrypted, true) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
