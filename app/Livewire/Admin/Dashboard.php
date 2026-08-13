<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\ReportService;
use App\Models\Donation;
use App\Models\Campaign;
use App\Models\Volunteer;
use App\Models\PaymentLog;

class Dashboard extends Component
{
    public function render()
    {
        $reportService = app(ReportService::class);
        $summary = $reportService->getExecutiveSummary();
        $recentDonations = Donation::with('campaign')->latest()->take(6)->get();
        $activeCampaigns = Campaign::where('status', 'active')->latest()->take(4)->get();
        $recentLogs = PaymentLog::latest()->take(5)->get();

        return view('livewire.admin.dashboard', [
            'summary' => $summary,
            'recentDonations' => $recentDonations,
            'activeCampaigns' => $activeCampaigns,
            'recentLogs' => $recentLogs,
        ])->layout('components.layouts.admin');
    }
}
