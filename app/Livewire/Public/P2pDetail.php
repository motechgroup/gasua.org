<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\P2pFundraiser;

class P2pDetail extends Component
{
    public P2pFundraiser $p2p;

    public function mount($slug)
    {
        $this->p2p = P2pFundraiser::with(['user', 'campaign', 'donations'])->where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.p2p-detail')->layout('components.layouts.app');
    }
}
