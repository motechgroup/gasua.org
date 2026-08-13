<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Services\ReportService;
use App\Models\TransparencyExpense;
use App\Models\Donation;

class TransparencyDashboard extends Component
{
    public function render()
    {
        $reportService = app(ReportService::class);
        $summary = $reportService->getExecutiveSummary();
        $expenses = TransparencyExpense::with('campaign')->latest()->take(10)->get();

        return view('livewire.public.transparency-dashboard', [
            'summary' => $summary,
            'expenses' => $expenses,
        ])->layout('components.layouts.app');
    }
}
