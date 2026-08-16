<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Donation;
use App\Services\DonationService;
use App\Services\Payments\PaymentManagerService;
use Livewire\WithPagination;

class DonationManager extends Component
{
    use WithPagination;

    public $search = '';
    public $status_filter = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }

    public function markAsCompleted($id)
    {
        $don = Donation::findOrFail($id);
        app(PaymentManagerService::class)->markAsCompleted($don);
        session()->flash('message', "Donation '{$don->transaction_reference}' marked as completed.");
    }

    public function deleteDonation($id)
    {
        $don = Donation::findOrFail($id);
        $ref = $don->transaction_reference;
        
        app(DonationService::class)->deleteDonation($don);

        session()->flash('message', "Donation '{$ref}' deleted successfully.");
    }

    public function render()
    {
        $query = Donation::with(['campaign', 'paymentGateway']);

        if (!empty($this->search)) {
            $searchTerm = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('transaction_reference', 'like', $searchTerm)
                  ->orWhere('donor_name', 'like', $searchTerm)
                  ->orWhere('donor_email', 'like', $searchTerm)
                  ->orWhere('gateway_code', 'like', $searchTerm);
            });
        }

        if (!empty($this->status_filter)) {
            $query->where('payment_status', $this->status_filter);
        }

        $donations = $query->latest()->paginate(15);

        return view('livewire.admin.donation-manager', ['donations' => $donations])
            ->layout('components.layouts.admin', ['headerTitle' => 'Donation Ledger & Admin Control']);
    }
}
