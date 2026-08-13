<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add additional user columns if missing
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('avatar');
            }
            if (!Schema::hasColumn('users', 'two_factor_secret')) {
                $table->text('two_factor_secret')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'two_factor_confirmed_at')) {
                $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_secret');
            }
        });

        // Campaigns
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary', 500)->nullable();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->decimal('goal_amount', 15, 2)->default(0.00);
            $table->decimal('raised_amount', 15, 2)->default(0.00);
            $table->unsignedInteger('donors_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('category')->default('general'); // feeding, education, health, talent, emergency, etc.
            $table->enum('status', ['draft', 'active', 'completed', 'paused'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_emergency')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Campaign Updates
        Schema::create('campaign_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        // Campaign Comments / Messages
        Schema::create('campaign_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->string('donor_name');
            $table->string('donor_email')->nullable();
            $table->text('comment');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        // Peer-to-Peer (P2P) Fundraisers
        Schema::create('p2p_fundraisers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('story')->nullable();
            $table->decimal('goal_amount', 15, 2)->default(0.00);
            $table->decimal('raised_amount', 15, 2)->default(0.00);
            $table->string('cover_image')->nullable();
            $table->enum('status', ['active', 'paused', 'completed'])->default('active');
            $table->timestamps();
        });

        // Payment Gateways
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // mpesa, flutterwave, dpo, paypal, nowpayments
            $table->string('name');
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_test_mode')->default(true);
            $table->boolean('is_default')->default(false);
            $table->longText('credentials')->nullable(); // Encrypted JSON payload
            $table->text('instructions')->nullable();
            $table->decimal('fee_percentage', 5, 2)->default(0.00);
            $table->timestamps();
        });

        // Donations
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_reference')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('p2p_fundraiser_id')->nullable()->constrained('p2p_fundraisers')->nullOnDelete();
            $table->unsignedBigInteger('talent_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('KES');
            $table->decimal('net_amount', 15, 2)->nullable();
            $table->decimal('fee_amount', 15, 2)->default(0.00);
            $table->string('donor_name')->default('Anonymous Donor');
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->string('donor_country', 100)->nullable()->default('Kenya');
            $table->text('donor_message')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_frequency', ['none', 'monthly', 'annual'])->default('none');
            $table->enum('donation_type', ['general', 'campaign', 'talent', 'memorial', 'emergency'])->default('general');
            $table->string('dedication_name')->nullable();
            $table->text('dedication_message')->nullable();
            $table->foreignId('payment_gateway_id')->nullable()->constrained('payment_gateways')->nullOnDelete();
            $table->string('gateway_code')->nullable(); // mpesa, flutterwave, dpo, paypal, nowpayments
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('payment_reference')->nullable(); // CheckoutRequestID, FlwRef, DpoTransRef, etc.
            $table->string('receipt_number')->nullable()->unique();
            $table->timestamps();
        });

        // Payment Logs
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('gateway_code');
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('status')->default('info');
            $table->timestamps();
        });

        // Webhook Logs
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_code');
            $table->string('event_type')->nullable();
            $table->json('payload')->nullable();
            $table->enum('status', ['processed', 'failed', 'retrying'])->default('processed');
            $table->unsignedInteger('retry_count')->default(0);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });

        // Donation Receipts
        Schema::create('donation_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->cascadeOnDelete();
            $table->string('receipt_number')->unique();
            $table->string('pdf_path')->nullable();
            $table->string('qr_code_hash')->unique();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_receipts');
        Schema::dropIfExists('webhook_logs');
        Schema::dropIfExists('payment_logs');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('payment_gateways');
        Schema::dropIfExists('p2p_fundraisers');
        Schema::dropIfExists('campaign_comments');
        Schema::dropIfExists('campaign_updates');
        Schema::dropIfExists('campaigns');
    }
};
