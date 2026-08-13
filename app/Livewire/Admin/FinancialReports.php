<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\ReportService;
use App\Models\Donation;
use App\Models\TransparencyExpense;

class FinancialReports extends Component
{
    public function render()
    {
        $reportService = app(ReportService::class);
        $summary = $reportService->getExecutiveSummary();
        $gatewayBreakdown = $reportService->getGatewayBreakdown();
        $monthlyTrends = $reportService->getMonthlyTrends();

        return view('livewire.admin.financial-reports', [
            'summary' => $summary,
            'gatewayBreakdown' => $gatewayBreakdown,
            'monthlyTrends' => $monthlyTrends,
        ])->layout('components.layouts.admin', ['headerTitle' => 'Financial Reports']);
    }
}
