<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\Campaign;
use App\Models\Volunteer;
use App\Models\Event;
use App\Models\TransparencyExpense;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getExecutiveSummary(): array
    {
        $totalRaised = Donation::where('payment_status', 'completed')->sum('amount');
        $totalDonationsCount = Donation::where('payment_status', 'completed')->count();
        $totalCampaignsCount = Campaign::count();
        $activeVolunteersCount = Volunteer::where('status', 'approved')->count();
        $totalExpenses = TransparencyExpense::sum('amount');
        $netFundBalance = max(0, $totalRaised - $totalExpenses);

        return [
            'total_raised' => $totalRaised,
            'total_donations_count' => $totalDonationsCount,
            'total_campaigns' => $totalCampaignsCount,
            'active_volunteers' => $activeVolunteersCount,
            'total_expenses' => $totalExpenses,
            'net_fund_balance' => $netFundBalance,
        ];
    }

    public function getGatewayBreakdown(): array
    {
        return Donation::where('payment_status', 'completed')
            ->select('gateway_code', DB::raw('COUNT(*) as total_count'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('gateway_code')
            ->get()
            ->toArray();
    }

    public function getMonthlyTrends(): array
    {
        $driver = DB::getDriverName();
        $dateExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m', created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m')";

        $donations = Donation::where('payment_status', 'completed')
            ->select(
                DB::raw("{$dateExpr} as month_year"),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(*) as total_count')
            )
            ->groupBy('month_year')
            ->orderBy('month_year', 'asc')
            ->limit(12)
            ->get();

        return $donations->toArray();
    }
}
