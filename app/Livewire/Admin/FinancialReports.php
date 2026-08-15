<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\ReportService;
use App\Models\Donation;
use App\Models\PaymentGateway;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FinancialReports extends Component
{
    use WithPagination;

    public $start_date = '';
    public $end_date = '';
    public $selected_gateway = '';
    public $selected_status = 'completed';

    protected $paginationTheme = 'tailwind';

    public function updatedStartDate() { $this->resetPage(); }
    public function updatedEndDate() { $this->resetPage(); }
    public function updatedSelectedGateway() { $this->resetPage(); }
    public function updatedSelectedStatus() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset(['start_date', 'end_date', 'selected_gateway']);
        $this->selected_status = 'completed';
        $this->resetPage();
    }

    public function exportCsv(): StreamedResponse
    {
        $filters = [
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'gateway_code' => $this->selected_gateway,
            'payment_status' => $this->selected_status,
        ];

        $reportService = app(ReportService::class);
        $donations = $reportService->getFilteredDonations($filters)->get();

        $fileName = 'gasua_financial_report_' . date('Y-m-d_H-i') . '.csv';

        return response()->streamDownload(function () use ($donations) {
            $handle = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($handle, [
                'Transaction Ref',
                'Donor Name',
                'Donor Email',
                'Donor Phone',
                'Amount',
                'Currency',
                'Payment Gateway',
                'Payment Status',
                'Campaign / Purpose',
                'Transaction Date'
            ]);

            // CSV Data Rows
            foreach ($donations as $d) {
                fputcsv($handle, [
                    $d->transaction_reference,
                    $d->donor_name,
                    $d->donor_email,
                    $d->donor_phone ?? '',
                    number_format($d->amount, 2, '.', ''),
                    $d->currency,
                    strtoupper($d->gateway_code),
                    ucfirst($d->payment_status),
                    $d->campaign->title ?? 'General Foundation Fund',
                    $d->created_at ? $d->created_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    public function render()
    {
        $filters = [
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'gateway_code' => $this->selected_gateway,
            'payment_status' => $this->selected_status,
        ];

        $reportService = app(ReportService::class);
        $summary = $reportService->getExecutiveSummary($filters);
        $gatewayBreakdown = $reportService->getGatewayBreakdown($filters);
        $donations = $reportService->getFilteredDonations($filters)->paginate(15);
        $availableGateways = PaymentGateway::all();

        return view('livewire.admin.financial-reports', [
            'summary' => $summary,
            'gatewayBreakdown' => $gatewayBreakdown,
            'donations' => $donations,
            'availableGateways' => $availableGateways,
        ])->layout('components.layouts.admin', ['headerTitle' => 'Financial Reports & Audits']);
    }
}
