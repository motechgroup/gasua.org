<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\CampaignUpdate;
use App\Models\Program;
use App\Models\Talent;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\GalleryItem;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\SiteSetting;
use App\Models\TransparencyExpense;
use App\Models\Donation;

class FoundationDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Site Settings
        SiteSetting::setKey('site_name', 'Gusii All Stars Foundation', 'general');
        SiteSetting::setKey('tagline', 'Empowering Talents, Feeding Families & Transforming Communities in Gusii', 'general');
        SiteSetting::setKey('contact_email', 'info@gusiiallstars.org', 'general');
        SiteSetting::setKey('contact_phone', '+254 700 123 456', 'general');
        SiteSetting::setKey('contact_address', 'Foundation House, Hospital Road, Kisii Town, Kenya', 'general');
        SiteSetting::setKey('currency', 'KES', 'general');
        SiteSetting::setKey('impact_meals_served', 25400, 'stats');
        SiteSetting::setKey('impact_children_sponsored', 380, 'stats');
        SiteSetting::setKey('impact_trees_planted', 12500, 'stats');
        SiteSetting::setKey('impact_talents_nurtured', 150, 'stats');
        SiteSetting::setKey('impact_projects_completed', 45, 'stats');
        SiteSetting::setKey('social_facebook', 'https://facebook.com/gusiiallstarsfoundation', 'social');
        SiteSetting::setKey('social_twitter', 'https://x.com/gusiiallstars', 'social');
        SiteSetting::setKey('social_instagram', 'https://instagram.com/gusiiallstars', 'social');

        // 2. Programs
        $programs = [
            [
                'title' => 'Talent Nurturing & Sports Development',
                'slug' => 'talent-development',
                'icon' => 'trophy',
                'short_description' => 'Scouting, training, and sponsoring young athletes, footballers, artists, and musicians in Kisii and Nyamira counties.',
                'full_content' => 'Gusii region is blessed with incredible athletic talent and creative artistry. Our Talent Development program provides structured academies, professional coaching, equipment, and international exposure for young stars.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Community Feeding & Food Security',
                'slug' => 'community-feeding',
                'icon' => 'utensils',
                'short_description' => 'Providing nutritious daily meals to vulnerable children, elderly citizens, and impoverished households.',
                'full_content' => 'No child should study on an empty stomach. Our feeding initiative supports primary school feeding programs and dispatches emergency food relief hampers to households facing extreme poverty.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Education & Scholarship Support',
                'slug' => 'education-support',
                'icon' => 'graduation-cap',
                'short_description' => 'Sponsoring school fees, textbooks, uniforms, and mentorship for needy bright students.',
                'full_content' => 'Education is the ultimate equalizer. We award full secondary and tertiary scholarships to deserving students who scored high grades but lack financial backing.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Free Community Health Camps',
                'slug' => 'health-camps',
                'icon' => 'heart-pulse',
                'short_description' => 'Organizing free medical checkups, eye surgery clinics, and essential medicine distribution across rural villages.',
                'full_content' => 'Our medical outreach brings doctors, nurses, and free prescription medicine directly to underserved communities in Gusii land.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Youth & Women Empowerment',
                'slug' => 'youth-women-empowerment',
                'icon' => 'users-group',
                'short_description' => 'Vocational training, micro-grants, and entrepreneurship workshops for youth and women groups.',
                'full_content' => 'Empowering women and youth with self-sustaining business skills, tailoring equipment, poultry farming kits, and revolving micro-loans.',
                'is_active' => true,
                'sort_order' => 5,
            ]
        ];

        foreach ($programs as $prog) {
            Program::updateOrCreate(['slug' => $prog['slug']], $prog);
        }

        // 3. Featured Campaigns
        $campaigns = [
            [
                'title' => 'Feed 500 Vulnerable Families in Kisii County',
                'slug' => 'feed-500-families',
                'summary' => 'Providing 1-month essential food hampers containing Maize Flour, Beans, Cooking Oil, Rice, and Sugar to 500 needy households.',
                'description' => 'Extreme drought and rising inflation have severely impacted low-income families in rural villages. Gusii All Stars Foundation aims to assemble and distribute 500 food relief packs before the end of the quarter. Each pack costs KES 3,000 ($25 USD) and supports a family of 5 for a whole month.',
                'goal_amount' => 1500000.00,
                'raised_amount' => 875000.00,
                'donors_count' => 142,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(45),
                'category' => 'Feeding',
                'status' => 'active',
                'is_featured' => true,
                'is_emergency' => true,
            ],
            [
                'title' => 'High School Scholarship Fund for 100 Needy Girls',
                'slug' => 'scholarships-100-girls',
                'summary' => 'Ensuring 100 vulnerable bright girls join Form 1 without dropping out due to lack of tuition fees and uniforms.',
                'description' => 'Many young girls in Gusii risk early marriage or dropping out when parents cannot afford secondary school fees. This campaign guarantees 4 years of secondary tuition, boarding supplies, and career mentorship for 100 girls.',
                'goal_amount' => 3000000.00,
                'raised_amount' => 1950000.00,
                'donors_count' => 218,
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(60),
                'category' => 'Education',
                'status' => 'active',
                'is_featured' => true,
                'is_emergency' => false,
            ],
            [
                'title' => 'Gusii Youth Football Academy Training Equipment & Kits',
                'slug' => 'youth-football-academy-kits',
                'summary' => 'Equipping 4 youth football teams (U-13, U-15, U-17, Senior) with boots, balls, jerseys, and field maintenance.',
                'description' => 'Sports keeps youth away from drug abuse and crime. Gusii All Stars Football Academy nurtures grassroots football talent with professional training, tournaments, and showcase trials for national league scouts.',
                'goal_amount' => 800000.00,
                'raised_amount' => 460000.00,
                'donors_count' => 74,
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(30),
                'category' => 'Talent',
                'status' => 'active',
                'is_featured' => true,
                'is_emergency' => false,
            ],
        ];

        foreach ($campaigns as $c) {
            $campaign = Campaign::updateOrCreate(['slug' => $c['slug']], $c);

            // Add sample campaign updates
            CampaignUpdate::create([
                'campaign_id' => $campaign->id,
                'title' => 'First Phase Food Hamper Distribution Complete!',
                'content' => 'Thanks to early donors, we delivered 150 food hampers in Suneka and Ogembo villages. See photos attached!',
            ]);
        }

        // 4. Talents Showcase
        $talents = [
            [
                'name' => 'Brian "Cheetah" Nyambane',
                'slug' => 'brian-nyambane-athletics',
                'category' => 'athletics',
                'bio' => '19-year-old middle-distance runner from Nyamira. Clocked 1:45.2 in 800m trials.',
                'achievements' => ['1st Place National Junior Trials 2025', 'Nyanza Regional Champion 800m'],
                'target_amount' => 250000.00,
                'raised_amount' => 110000.00,
                'is_featured' => true,
            ],
            [
                'name' => 'Faith Kemunto - Afropop Vocalist',
                'slug' => 'faith-kemunto-music',
                'category' => 'music',
                'bio' => 'Gifted singer and songwriter composing fusion music in Ekegusii and English.',
                'achievements' => ['Winner Gusii Music Awards 2024', '100,000+ Streams on YouTube'],
                'target_amount' => 180000.00,
                'raised_amount' => 95000.00,
                'is_featured' => true,
            ],
        ];

        foreach ($talents as $t) {
            Talent::updateOrCreate(['slug' => $t['slug']], $t);
        }

        // 5. Events
        $events = [
            [
                'title' => 'Gusii Annual Charity Walk & Marathon 2026',
                'slug' => 'charity-walk-2026',
                'description' => 'Join over 2,000 participants walking 15KM from Kisii Stadium to Suneka to raise funds for childhood cancer treatment and feeding programs.',
                'event_date' => now()->addDays(20),
                'location_name' => 'Gusii Stadium, Kisii',
                'address' => 'Hospital Road, Kisii Town',
                'ticket_price' => 500.00,
                'max_participants' => 2500,
                'registered_count' => 450,
                'goal_amount' => 2000000.00,
                'raised_amount' => 650000.00,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Free Community Eye & Dental Medical Camp',
                'slug' => 'free-medical-camp-2026',
                'description' => 'Free consultations, cataract screening, dental checkups, and prescription glasses distribution for all residents.',
                'event_date' => now()->addDays(35),
                'location_name' => 'Nyamira Level 4 Hospital Grounds',
                'address' => 'Nyamira Town',
                'ticket_price' => 0.00,
                'max_participants' => 1000,
                'registered_count' => 280,
                'goal_amount' => 1000000.00,
                'raised_amount' => 400000.00,
                'status' => 'upcoming',
            ]
        ];

        foreach ($events as $ev) {
            Event::updateOrCreate(['slug' => $ev['slug']], $ev);
        }

        // 6. News & Blog
        $news = [
            [
                'title' => 'Gusii All Stars Foundation Launches Mobile Clinic in Remote Villages',
                'slug' => 'mobile-clinic-launch-2026',
                'category' => 'Success Story',
                'excerpt' => 'Over 1,200 villagers received free medical care during the maiden voyage of the Gusii Mobile Health Unit.',
                'content' => '<p>Access to quality healthcare has been a longstanding challenge for rural communities in Kisii and Nyamira. Yesterday marked a milestone as Gusii All Stars Foundation deployed its fully equipped mobile medical clinic.</p><p>Dr. Omwenga, leading the medical team, stated: "We treated over 300 children with acute respiratory infections and provided free diabetes screening for senior citizens."</p>',
                'published_at' => now()->subDays(5),
                'status' => 'published',
                'views_count' => 1240,
            ],
            [
                'title' => '10 Foundation Scholars Graduate with First Class Honors',
                'slug' => '10-scholars-graduate-first-class',
                'category' => 'Announcement',
                'excerpt' => 'A proud moment as 10 students sponsored by Gusii All Stars Foundation graduated from Kenyan universities.',
                'content' => '<p>Four years ago, these bright students could not afford high school tuition. Today, they hold degrees in Computer Science, Medicine, and Civil Engineering from top universities.</p>',
                'published_at' => now()->subDays(12),
                'status' => 'published',
                'views_count' => 890,
            ]
        ];

        foreach ($news as $n) {
            NewsArticle::updateOrCreate(['slug' => $n['slug']], $n);
        }

        // 7. Testimonials
        $testimonials = [
            [
                'name' => 'Mama Mary Mogaka',
                'role_description' => 'Beneficiary - Feeding Program',
                'quote' => 'When my husband passed away, I struggled to put food on the table for my 4 grandchildren. Gusii All Stars Foundation came to our rescue with monthly food packs. God bless the donors!',
                'is_featured' => true,
            ],
            [
                'name' => 'David Ongeri',
                'role_description' => 'Foundation Alumni & Software Engineer',
                'quote' => 'Without the Gusii All Stars High School Scholarship, I would have dropped out in Form 2. Today I am a software developer giving back to the foundation.',
                'is_featured' => true,
            ],
        ];

        foreach ($testimonials as $tst) {
            Testimonial::create($tst);
        }

        // 8. Partners
        $partners = [
            ['name' => 'Safaricom Foundation', 'tier' => 'platinum', 'is_active' => true],
            ['name' => 'Equity Group Foundation', 'tier' => 'gold', 'is_active' => true],
            ['name' => 'Kisii County Government', 'tier' => 'gold', 'is_active' => true],
            ['name' => 'Kenya Red Cross', 'tier' => 'silver', 'is_active' => true],
        ];

        foreach ($partners as $p) {
            Partner::create($p);
        }

        // 9. Transparency Expenses
        $firstCampaign = Campaign::first();
        if ($firstCampaign) {
            TransparencyExpense::create([
                'title' => 'Purchase of 150 Food Relief Packs (Maize Flour, Rice, Beans, Oil)',
                'campaign_id' => $firstCampaign->id,
                'amount' => 450000.00,
                'expense_date' => now()->subDays(7),
                'description' => 'Direct supplier payment to Kisii Grain Millers for 150 relief packs distributed in Suneka.',
                'category' => 'Relief Supplies',
            ]);
        }

        // 10. Sample Completed Donations
        if ($firstCampaign) {
            Donation::create([
                'transaction_reference' => 'GAS-DON-'.strtoupper(\Illuminate\Support\Str::random(8)),
                'campaign_id' => $firstCampaign->id,
                'amount' => 10000.00,
                'currency' => 'KES',
                'net_amount' => 10000.00,
                'fee_amount' => 0.00,
                'donor_name' => 'Hon. Charles Nyachae',
                'donor_email' => 'charles@example.com',
                'donor_phone' => '254711223344',
                'donor_country' => 'Kenya',
                'donor_message' => 'Keep up the great work serving our people in Gusii!',
                'is_anonymous' => false,
                'gateway_code' => 'mpesa',
                'payment_status' => 'completed',
                'payment_reference' => 'RKT9928371',
                'receipt_number' => 'REC-2026-0001',
            ]);

            Donation::create([
                'transaction_reference' => 'GAS-DON-'.strtoupper(\Illuminate\Support\Str::random(8)),
                'campaign_id' => $firstCampaign->id,
                'amount' => 150.00,
                'currency' => 'USD',
                'net_amount' => 147.00,
                'fee_amount' => 3.00,
                'donor_name' => 'Anonymous Supporter',
                'donor_email' => 'donor.usa@example.com',
                'donor_country' => 'United States',
                'donor_message' => 'Praying for all the families supported by the foundation.',
                'is_anonymous' => true,
                'gateway_code' => 'flutterwave',
                'payment_status' => 'completed',
                'payment_reference' => 'FLW-8827192',
                'receipt_number' => 'REC-2026-0002',
            ]);
        }
    }
}
