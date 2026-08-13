<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Campaign;

class CampaignsIndex extends Component
{
    public $search = '';
    public $category = 'all';

    public function render()
    {
        $query = Campaign::where('status', 'active');

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        $campaigns = $query->latest()->get();

        return view('livewire.public.campaigns-index', [
            'campaigns' => $campaigns,
        ])->layout('components.layouts.app');
    }
}
