<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Campaign;
use App\Models\Talent;
use App\Models\PaymentGateway;
use App\Models\Donation;
use App\Services\DonationService;
use App\Services\Payments\PaymentManagerService;

class DonationCheckout extends Component
{
    public $campaign_id = null;
    public $talent_id = null;
    public $p2p_fundraiser_id = null;
    public $program_id = null;

    public $amount = 1000;
    public $custom_amount = '';
    public $currency = 'KES';
    public $donation_type = 'campaign';
    public $is_recurring = false;
    public $recurring_frequency = 'none';

    public $donor_name = '';
    public $donor_email = '';
    public $donor_phone = '';
    public $donor_country = 'Kenya';
    public $donor_message = '';
    public $is_anonymous = false;
    public $dedication_name = '';

    public $gateway_code = ''; // Unselected by default so form reveals cleanly on gateway click
    public $crypto_coin = 'usdttrc20';

    // State after initiation
    public $activeDonation = null;
    public $paymentResult = null;
    public $isProcessing = false;
    public $isSuccess = false;
    public $errorMessage = '';

    public function getPresetAmountsProperty(): array
    {
        if ($this->currency === 'USD') {
            $raw = \App\Models\SiteSetting::getByKey('preset_amounts_usd', '10, 25, 50, 100, 250');
        } else {
            $raw = \App\Models\SiteSetting::getByKey('preset_amounts_kes', '500, 1000, 2500, 5000, 10000');
        }

        $items = array_map('trim', explode(',', (string) $raw));
        $numeric = [];
        foreach ($items as $item) {
            if (is_numeric($item) && (float)$item > 0) {
                $numeric[] = (float)$item;
            }
        }

        return !empty($numeric) ? $numeric : ($this->currency === 'USD' ? [10, 25, 50, 100, 250] : [500, 1000, 2500, 5000, 10000]);
    }

    public function mount()
    {
        $defaultAmount = (float) \App\Models\SiteSetting::getByKey('default_donation_amount', 1000);
        $this->amount = $defaultAmount > 0 ? $defaultAmount : 1000;

        $this->campaign_id = request()->query('campaign');
        $this->talent_id = request()->query('talent');
        $this->p2p_fundraiser_id = request()->query('p2p');
        $this->program_id = request()->query('program');

        $ref = request()->query('reference');
        $sessionId = request()->query('session_id');
        $status = request()->query('status');

        if ($ref) {
            $this->activeDonation = Donation::where('transaction_reference', $ref)
                ->orWhere('payment_reference', $ref)
                ->first();
            if ($this->activeDonation) {
                if ($sessionId && $this->activeDonation->gateway_code === 'stripe') {
                    $verify = app(PaymentManagerService::class)->driver('stripe')->verifyPayment($sessionId);
                    if (($verify['status'] ?? '') === 'completed') {
                        app(PaymentManagerService::class)->markAsCompleted($this->activeDonation);
                        $this->isSuccess = true;
                    }
                } elseif ($this->activeDonation->gateway_code === 'paystack') {
                    $verify = app(PaymentManagerService::class)->driver('paystack')->verifyPayment($ref);
                    if (($verify['status'] ?? '') === 'completed') {
                        app(PaymentManagerService::class)->markAsCompleted($this->activeDonation, $verify['receipt'] ?? $ref);
                        $this->isSuccess = true;
                    }
                } elseif ($status === 'success' || request()->query('simulated')) {
                    app(PaymentManagerService::class)->markAsCompleted($this->activeDonation);
                    $this->isSuccess = true;
                }
            }
        }
    }

    public function selectAmount($val)
    {
        $this->amount = $val;
        $this->custom_amount = '';
    }

    public function selectGateway($code)
    {
        $this->gateway_code = $code;
        $this->errorMessage = '';
    }

    public function processDonation()
    {
        // Sanitize string inputs
        $this->donor_name = trim(strip_tags($this->donor_name));
        $this->donor_email = trim(strtolower($this->donor_email));
        $this->donor_phone = trim(strip_tags($this->donor_phone));
        $this->donor_country = trim(strip_tags($this->donor_country));
        $this->donor_message = trim(strip_tags($this->donor_message));
        $this->dedication_name = trim(strip_tags($this->dedication_name));
        $this->gateway_code = trim(strip_tags($this->gateway_code));

        $finalAmount = !empty($this->custom_amount) ? (float)$this->custom_amount : (float)$this->amount;

        if (empty($this->gateway_code)) {
            $this->errorMessage = 'Please choose a payment gateway to complete your donation.';
            return;
        }

        if ($finalAmount < 10 || $finalAmount > 10000000) {
            $this->errorMessage = 'Donation amount must be between KES 10 and KES 10,000,000.';
            return;
        }

        // Custom validation per gateway
        if ($this->gateway_code === 'mpesa') {
            $this->validate([
                'donor_phone' => 'required|string|min:9|max:20',
            ], [
                'donor_phone.required' => 'Please enter your M-Pesa mobile number to receive the STK Push prompt.',
            ]);

            $donorName = !empty($this->donor_name) ? $this->donor_name : ($this->is_anonymous ? 'Anonymous Donor' : 'M-Pesa Donor');
            $donorEmail = !empty($this->donor_email) ? $this->donor_email : 'donor@gusiiallstars.org';
        } else {
            $this->validate([
                'donor_email' => 'required|email|max:150',
            ], [
                'donor_email.required' => 'Please enter your email address to receive your official PDF receipt.',
            ]);

            $donorName = !empty($this->donor_name) ? $this->donor_name : ($this->is_anonymous ? 'Anonymous Donor' : 'Kind Donor');
            $donorEmail = $this->donor_email;
        }

        try {
            $this->isProcessing = true;
            $this->errorMessage = '';

            $donationService = app(DonationService::class);
            $donation = $donationService->createPendingDonation([
                'amount' => $finalAmount,
                'currency' => $this->currency,
                'campaign_id' => $this->campaign_id,
                'talent_id' => $this->talent_id,
                'p2p_fundraiser_id' => $this->p2p_fundraiser_id,
                'donor_name' => $donorName,
                'donor_email' => $donorEmail,
                'donor_phone' => $this->donor_phone,
                'donor_country' => $this->donor_country,
                'donor_message' => $this->donor_message,
                'is_anonymous' => $this->is_anonymous,
                'is_recurring' => $this->is_recurring,
                'recurring_frequency' => $this->is_recurring ? $this->recurring_frequency : 'none',
                'donation_type' => $this->donation_type,
                'dedication_name' => $this->dedication_name,
                'gateway_code' => $this->gateway_code,
            ]);

            $this->activeDonation = $donation;
            $paymentManager = app(PaymentManagerService::class);
            
            $this->paymentResult = $paymentManager->initiate($donation, [
                'phone' => $this->donor_phone,
                'crypto_coin' => $this->crypto_coin,
            ]);

            if (!empty($this->paymentResult['redirect_url'])) {
                return redirect()->away($this->paymentResult['redirect_url']);
            }

            if ($this->paymentResult['success'] && ($this->paymentResult['status'] ?? '') === 'completed') {
                $this->isSuccess = true;
            }

        } catch (\Exception $e) {
            $this->errorMessage = 'Donation processing error: ' . $e->getMessage();
        } finally {
            $this->isProcessing = false;
        }
    }

    public function checkMpesaStatus()
    {
        if (!$this->activeDonation) return;

        $driver = app(PaymentManagerService::class)->driver('mpesa');
        $res = $driver->verifyPayment($this->activeDonation->payment_reference ?? '');

        if (($res['status'] ?? '') === 'completed') {
            app(PaymentManagerService::class)->markAsCompleted($this->activeDonation);
            $this->activeDonation->refresh();
            $this->isSuccess = true;
        }
    }

    public function render()
    {
        $enabledGateways = PaymentGateway::where('is_enabled', true)->get();
        $selectedCampaign = $this->campaign_id ? Campaign::find($this->campaign_id) : null;
        $selectedTalent = $this->talent_id ? Talent::find($this->talent_id) : null;
        $selectedProgram = $this->program_id ? \App\Models\Program::find($this->program_id) : null;

        return view('livewire.public.donation-checkout', [
            'gateways' => $enabledGateways,
            'selectedCampaign' => $selectedCampaign,
            'selectedTalent' => $selectedTalent,
            'selectedProgram' => $selectedProgram,
        ])->layout('components.layouts.app');
    }
}
