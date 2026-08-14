<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Donation;
use App\Models\PaymentGateway;
use App\Services\Payments\PaymentManagerService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StripeGatewayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_stripe_gateway_exists_in_database(): void
    {
        $this->assertDatabaseHas('payment_gateways', [
            'code' => 'stripe',
            'is_enabled' => true,
        ]);
    }

    public function test_can_resolve_stripe_driver(): void
    {
        $manager = app(PaymentManagerService::class);
        $driver = $manager->driver('stripe');

        $this->assertInstanceOf(\App\Services\Payments\Drivers\StripeGatewayService::class, $driver);
    }
}
