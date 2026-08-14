<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\Campaign;
use App\Models\P2pFundraiser;
use App\Models\Talent;
use App\Models\PaymentGateway;
use Illuminate\Support\Str;

class DonationService
{
    public function createPendingDonation(array $data): Donation
    {
        $gateway = PaymentGateway::where('code', $data['gateway_code'] ?? 'mpesa')->first();
        $feePct = 0.00;
        $feeAmount = 0.00;
        $netAmount = $data['amount'];

        $ref = 'GAS-DON-' . strtoupper(Str::random(8));

        return Donation::create([
            'transaction_reference' => $ref,
            'user_id' => auth()->id(),
            'campaign_id' => $data['campaign_id'] ?? null,
            'p2p_fundraiser_id' => $data['p2p_fundraiser_id'] ?? null,
            'talent_id' => $data['talent_id'] ?? null,
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'KES',
            'net_amount' => $netAmount,
            'fee_amount' => $feeAmount,
            'donor_name' => (!empty($data['is_anonymous']) && $data['is_anonymous']) ? 'Anonymous Donor' : ($data['donor_name'] ?? 'Kind Donor'),
            'donor_email' => $data['donor_email'] ?? null,
            'donor_phone' => $data['donor_phone'] ?? null,
            'donor_country' => $data['donor_country'] ?? 'Kenya',
            'donor_message' => $data['donor_message'] ?? null,
            'is_anonymous' => $data['is_anonymous'] ?? false,
            'is_recurring' => $data['is_recurring'] ?? false,
            'recurring_frequency' => $data['recurring_frequency'] ?? 'none',
            'donation_type' => $data['donation_type'] ?? 'general',
            'dedication_name' => $data['dedication_name'] ?? null,
            'dedication_message' => $data['dedication_message'] ?? null,
            'payment_gateway_id' => $gateway?->id,
            'gateway_code' => $data['gateway_code'] ?? 'mpesa',
            'payment_status' => 'pending',
        ]);
    }

    public function finalizeDonation(Donation $donation, ?string $paymentRef = null, ?string $receiptNo = null): Donation
    {
        if ($donation->payment_status === 'completed') {
            return $donation;
        }

        $receiptNo = $receiptNo ?? 'REC-' . date('Y') . '-' . str_pad((string)($donation->id), 5, '0', STR_PAD_LEFT);

        $donation->update([
            'payment_status' => 'completed',
            'payment_reference' => $paymentRef ?? $donation->payment_reference ?? $donation->transaction_reference,
            'receipt_number' => $receiptNo,
        ]);

        // Increment raised amount on Campaign
        if ($donation->campaign_id) {
            $campaign = Campaign::find($donation->campaign_id);
            if ($campaign) {
                $campaign->increment('raised_amount', $donation->amount);
                $campaign->increment('donors_count');
            }
        }

        // Increment raised amount on P2P Fundraiser
        if ($donation->p2p_fundraiser_id) {
            $p2p = P2pFundraiser::find($donation->p2p_fundraiser_id);
            if ($p2p) {
                $p2p->increment('raised_amount', $donation->amount);
            }
        }

        // Increment raised amount on Talent profile
        if ($donation->talent_id) {
            $talent = Talent::find($donation->talent_id);
            if ($talent) {
                $talent->increment('raised_amount', $donation->amount);
            }
        }

        // Generate receipt
        app(ReceiptService::class)->generateReceiptRecord($donation);

        return $donation;
    }
}
