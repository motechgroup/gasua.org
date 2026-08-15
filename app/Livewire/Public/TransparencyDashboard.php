<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Services\ReportService;
use App\Models\TransparencyExpense;
use App\Models\Donation;
use App\Models\SiteSetting;

class TransparencyDashboard extends Component
{
    public function render()
    {
        $isEnabled = (bool) SiteSetting::getByKey('enable_public_transparency', true);
        
        $reportService = app(ReportService::class);
        $summary = $isEnabled ? $reportService->getExecutiveSummary() : [];
        $expenses = $isEnabled ? TransparencyExpense::with('campaign')->latest()->take(10)->get() : collect();

        return view('livewire.public.transparency-dashboard', [
            'isEnabled' => $isEnabled,
            'summary' => $summary,
            'expenses' => $expenses,
        ])->layout('components.layouts.app');
    }
}
