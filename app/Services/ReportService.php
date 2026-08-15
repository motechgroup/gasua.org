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
    protected function applyDonationFilters($query, array $filters)
    {
        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }
        if (!empty($filters['gateway_code'])) {
            $query->where('gateway_code', $filters['gateway_code']);
        }
        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }
        return $query;
    }

    public function getExecutiveSummary(array $filters = []): array
    {
        $donationQuery = Donation::query();
        if (empty($filters['payment_status'])) {
            $donationQuery->where('payment_status', 'completed');
        }
        $donationQuery = $this->applyDonationFilters($donationQuery, $filters);

        $totalRaised = (float) (clone $donationQuery)->sum('amount');
        $totalDonationsCount = (clone $donationQuery)->count();

        $expenseQuery = TransparencyExpense::query();
        if (!empty($filters['start_date'])) {
            $expenseQuery->whereDate('expense_date', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $expenseQuery->whereDate('expense_date', '<=', $filters['end_date']);
        }
        $totalExpenses = (float) $expenseQuery->sum('amount');
        $netFundBalance = max(0, $totalRaised - $totalExpenses);

        return [
            'total_raised' => $totalRaised,
            'total_donations_count' => $totalDonationsCount,
            'total_campaigns' => Campaign::count(),
            'active_volunteers' => Volunteer::where('status', 'approved')->count(),
            'total_expenses' => $totalExpenses,
            'net_fund_balance' => $netFundBalance,
        ];
    }

    public function getGatewayBreakdown(array $filters = []): array
    {
        $query = Donation::query();
        if (empty($filters['payment_status'])) {
            $query->where('payment_status', 'completed');
        }
        $query = $this->applyDonationFilters($query, $filters);

        return $query
            ->select('gateway_code', DB::raw('COUNT(*) as total_count'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('gateway_code')
            ->get()
            ->toArray();
    }

    public function getFilteredDonations(array $filters = [])
    {
        $query = Donation::with('campaign');
        $query = $this->applyDonationFilters($query, $filters);
        return $query->latest();
    }
}
