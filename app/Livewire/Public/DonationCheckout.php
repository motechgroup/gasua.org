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

    public $amount = 1000;
    public $custom_amount = '';
    public $currency = 'KES';
    public $donation_type = 'campaign'; // general, campaign, talent, memorial
    public $is_recurring = false;
    public $recurring_frequency = 'none'; // monthly, annual

    public $donor_name = '';
    public $donor_email = '';
    public $donor_phone = '';
    public $donor_country = 'Kenya';
    public $donor_message = '';
    public $is_anonymous = false;
    public $dedication_name = '';

    public $gateway_code = 'mpesa';
    public $crypto_coin = 'usdttrc20';

    // State after initiation
    public $activeDonation = null;
    public $paymentResult = null;
    public $isProcessing = false;
    public $isSuccess = false;
    public $errorMessage = '';

    public function mount()
    {
        $this->campaign_id = request()->query('campaign');
        $this->talent_id = request()->query('talent');
        $this->p2p_fundraiser_id = request()->query('p2p');

        $ref = request()->query('reference');
        $sessionId = request()->query('session_id');
        $status = request()->query('status');

        if ($ref) {
            $this->activeDonation = Donation::where('transaction_reference', $ref)->first();
            if ($this->activeDonation) {
                if ($sessionId && $this->activeDonation->gateway_code === 'stripe') {
                    $verify = app(PaymentManagerService::class)->driver('stripe')->verifyPayment($sessionId);
                    if (($verify['status'] ?? '') === 'completed') {
                        app(PaymentManagerService::class)->markAsCompleted($this->activeDonation);
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

    public function processDonation()
    {
        $finalAmount = !empty($this->custom_amount) ? (float)$this->custom_amount : (float)$this->amount;

        $this->validate([
            'donor_name' => $this->is_anonymous ? 'nullable' : 'required|string|max:100',
            'donor_email' => 'required|email',
            'donor_phone' => $this->gateway_code === 'mpesa' ? 'required|string' : 'nullable|string',
            'gateway_code' => 'required|string',
        ]);

        if ($finalAmount <= 0) {
            $this->errorMessage = 'Please enter a valid donation amount.';
            return;
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
                'donor_name' => $this->donor_name,
                'donor_email' => $this->donor_email,
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
            $this->errorMessage = 'Donation initialization error: ' . $e->getMessage();
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

        return view('livewire.public.donation-checkout', [
            'gateways' => $enabledGateways,
            'selectedCampaign' => $selectedCampaign,
            'selectedTalent' => $selectedTalent,
        ])->layout('components.layouts.app');
    }
}
