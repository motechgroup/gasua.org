<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Donation;

class DonationManager extends Component
{
    public function markAsCompleted($id)
    {
        $don = Donation::findOrFail($id);
        app(\App\Services\Payments\PaymentManagerService::class)->markAsCompleted($don);
    }

    public function render()
    {
        $donations = Donation::with(['campaign', 'paymentGateway'])->latest()->take(50)->get();
        return view('livewire.admin.donation-manager', ['donations' => $donations])
            ->layout('components.layouts.admin', ['headerTitle' => 'Donation Management']);
    }
}
