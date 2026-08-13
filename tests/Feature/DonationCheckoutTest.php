<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\DonationService;
use App\Services\Payments\PaymentManagerService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_create_pending_donation(): void
    {
        $campaign = Campaign::first();

        $service = app(DonationService::class);
        $donation = $service->createPendingDonation([
            'amount' => 2500.00,
            'currency' => 'KES',
            'campaign_id' => $campaign->id,
            'donor_name' => 'Jane Nyaboke',
            'donor_email' => 'jane@example.com',
            'donor_phone' => '254712345678',
            'gateway_code' => 'mpesa',
        ]);

        $this->assertDatabaseHas('donations', [
            'transaction_reference' => $donation->transaction_reference,
            'amount' => 2500.00,
            'gateway_code' => 'mpesa',
            'payment_status' => 'pending',
        ]);
    }

    public function test_mpesa_stk_push_initiation(): void
    {
        $donation = Donation::first();

        $manager = app(PaymentManagerService::class);
        $result = $manager->initiate($donation, [
            'phone' => '254712345678',
        ]);

        $this->assertTrue($result['success']);
        $this->assertNotEmpty($result['payment_reference']);
    }

    public function test_finalizing_donation_updates_campaign_raised_amount(): void
    {
        $campaign = Campaign::first();
        $initialRaised = $campaign->raised_amount;

        $donation = Donation::create([
            'transaction_reference' => 'TEST-REF-999',
            'campaign_id' => $campaign->id,
            'amount' => 5000.00,
            'currency' => 'KES',
            'donor_name' => 'Test Donor',
            'gateway_code' => 'mpesa',
            'payment_status' => 'pending',
        ]);

        $service = app(DonationService::class);
        $service->finalizeDonation($donation, 'MPE-12345');

        $campaign->refresh();
        $this->assertEquals($initialRaised + 5000.00, $campaign->raised_amount);
        $this->assertDatabaseHas('donation_receipts', [
            'donation_id' => $donation->id,
        ]);
    }
}
