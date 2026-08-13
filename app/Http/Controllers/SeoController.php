<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\NewsArticle;

class SeoController extends Controller
{
    public function sitemapXml()
    {
        $urls = [
            route('home'),
            route('public.about'),
            route('public.programs'),
            route('public.talents'),
            route('public.campaigns'),
            route('public.events'),
            route('public.news'),
            route('public.gallery'),
            route('public.transparency'),
            route('public.volunteer'),
            route('public.contact'),
            route('public.donate'),
        ];

        $campaigns = Campaign::where('status', 'active')->get();
        foreach ($campaigns as $c) {
            $urls[] = route('public.campaigns.show', $c->slug);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url) {
            $xml .= '<url><loc>' . htmlspecialchars($url) . '</loc><changefreq>daily</changefreq><priority>0.8</priority></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robotsTxt()
    {
        $content = "User-agent: *\nDisallow: /admin/\nAllow: /\nSitemap: " . url('/sitemap.xml');
        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
