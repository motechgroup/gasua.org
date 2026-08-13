<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Donation;

class DonorDashboard extends Component
{
    public function render()
    {
        $donations = Donation::with(['campaign', 'paymentGateway'])
            ->where(function($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('donor_email', auth()->user()?->email);
            })
            ->latest()
            ->get();

        return view('livewire.public.donor-dashboard', [
            'donations' => $donations,
        ])->layout('components.layouts.app');
    }
}
