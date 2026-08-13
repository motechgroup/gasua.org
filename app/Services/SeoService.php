<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\SiteSetting;

class SeoService
{
    public function generateOrganizationJsonLd(): string
    {
        $siteName = SiteSetting::getByKey('site_name', 'Gusii All Stars Foundation');
        $email = SiteSetting::getByKey('contact_email', 'info@gusiiallstars.org');
        $phone = SiteSetting::getByKey('contact_phone', '+254700123456');

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NGO',
            'name' => $siteName,
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'description' => 'Official Charity Foundation in Gusii Region, Kenya.',
            'telephone' => $phone,
            'email' => $email,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Kisii Town',
                'addressRegion' => 'Kisii County',
                'addressCountry' => 'KE'
            ],
            'sameAs' => [
                SiteSetting::getByKey('social_facebook', 'https://facebook.com'),
                SiteSetting::getByKey('social_twitter', 'https://x.com'),
            ]
        ];

        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function generateCampaignJsonLd(Campaign $campaign): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'DonateAction',
            'name' => $campaign->title,
            'description' => $campaign->summary,
            'recipient' => [
                '@type' => 'NGO',
                'name' => 'Gusii All Stars Foundation'
            ],
            'price' => $campaign->goal_amount,
            'priceCurrency' => 'KES',
            'url' => route('public.campaigns.show', $campaign->slug),
        ];

        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
