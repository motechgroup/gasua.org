<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Campaign;
use App\Models\Program;
use App\Models\Talent;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\SiteSetting;

class HomePage extends Component
{
    public function render()
    {
        $featuredCampaigns = Campaign::where('status', 'active')->where('is_featured', true)->take(3)->get();
        $programs = Program::where('is_active', true)->orderBy('sort_order')->take(4)->get();
        $featuredTalents = Talent::where('is_featured', true)->take(3)->get();
        $upcomingEvents = Event::where('status', 'upcoming')->orderBy('event_date')->take(2)->get();
        $latestNews = NewsArticle::where('status', 'published')->latest('published_at')->take(3)->get();
        $testimonials = Testimonial::where('status', 'active')->where('is_featured', true)->take(4)->get();
        $partners = Partner::where('is_active', true)->orderBy('sort_order')->take(6)->get();

        $stats = [
            'meals' => SiteSetting::getByKey('impact_meals_served', 25400),
            'children' => SiteSetting::getByKey('impact_children_sponsored', 380),
            'trees' => SiteSetting::getByKey('impact_trees_planted', 12500),
            'talents' => SiteSetting::getByKey('impact_talents_nurtured', 150),
        ];

        return view('livewire.public.home-page', [
            'featuredCampaigns' => $featuredCampaigns,
            'programs' => $programs,
            'featuredTalents' => $featuredTalents,
            'upcomingEvents' => $upcomingEvents,
            'latestNews' => $latestNews,
            'testimonials' => $testimonials,
            'partners' => $partners,
            'stats' => $stats,
        ])->layout('components.layouts.app');
    }
}
