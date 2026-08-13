<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Programs
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // Lucide or FontAwesome icon name
            $table->string('short_description', 500)->nullable();
            $table->longText('full_content')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Talents Showcase
        Schema::create('talents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('category', ['football', 'athletics', 'music', 'dance', 'drama', 'comedy', 'poetry', 'models'])->default('football');
            $table->text('bio')->nullable();
            $table->json('achievements')->nullable(); // Array of awards/milestones
            $table->json('photos')->nullable();
            $table->string('video_url')->nullable(); // YouTube or Vimeo link
            $table->string('profile_image')->nullable();
            $table->decimal('target_amount', 15, 2)->default(0.00);
            $table->decimal('raised_amount', 15, 2)->default(0.00);
            $table->text('sponsor_info')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // Events
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->dateTime('event_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location_name');
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('ticket_price', 10, 2)->default(0.00); // 0 = free
            $table->unsignedInteger('max_participants')->nullable();
            $table->unsignedInteger('registered_count')->default(0);
            $table->decimal('goal_amount', 15, 2)->default(0.00);
            $table->decimal('raised_amount', 15, 2)->default(0.00);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->timestamps();
        });

        // Event Registrations
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('ticket_code')->unique();
            $table->enum('status', ['confirmed', 'cancelled', 'checked_in'])->default('confirmed');
            $table->enum('payment_status', ['free', 'pending', 'paid'])->default('free');
            $table->timestamps();
        });

        // Volunteers Management
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('county')->default('Kisii');
            $table->text('address')->nullable();
            $table->json('skills')->nullable(); // Array of skills e.g., ["Coaching", "Event Planning", "Medical"]
            $table->string('availability')->nullable(); // Full-time, Weekends, Events only
            $table->text('motivation')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Event Volunteer Assignments
        Schema::create('event_volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('volunteer_id')->constrained()->cascadeOnDelete();
            $table->string('assigned_role')->nullable();
            $table->timestamps();
        });

        // News & Blog Articles
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('General'); // Success Story, Announcement, Press Release, Blog
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->json('tags')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->timestamps();
        });

        // Gallery Items (Photos & Videos)
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('Community Work');
            $table->enum('media_type', ['photo', 'video'])->default('photo');
            $table->string('file_path')->nullable();
            $table->string('video_url')->nullable(); // YouTube or Vimeo embed URL
            $table->string('thumbnail')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // Testimonials CMS
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role_description')->nullable(); // e.g. Beneficiary, Volunteer, Monthly Donor
            $table->string('photo')->nullable();
            $table->text('quote');
            $table->string('video_url')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->enum('status', ['active', 'hidden'])->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Partners & Sponsors
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('website_url')->nullable();
            $table->enum('tier', ['platinum', 'gold', 'silver', 'corporate', 'community'])->default('corporate');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Newsletter Subscribers
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_verified')->default(true);
            $table->string('token')->nullable();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamps();
        });

        // Contact Messages & Inquiries
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->enum('status', ['unread', 'read', 'replied', 'archived'])->default('unread');
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
        });

        // Financial Transparency Expenses
        Schema::create('transparency_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 15, 2);
            $table->date('expense_date');
            $table->text('description')->nullable();
            $table->string('proof_document')->nullable(); // PDF or image receipt/audit document
            $table->string('category')->default('Program Delivery'); // Administration, Relief Supplies, Medical, Transport
            $table->timestamps();
        });

        // Site Settings (CMS Key-Value Store)
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general');
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->timestamps();
        });

        // Audit Logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('transparency_expenses');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('news_articles');
        Schema::dropIfExists('event_volunteers');
        Schema::dropIfExists('volunteers');
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('events');
        Schema::dropIfExists('talents');
        Schema::dropIfExists('programs');
    }
};
