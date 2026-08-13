<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\P2pFundraiser;
use App\Models\Campaign;
use Illuminate\Support\Str;

class P2pCreate extends Component
{
    public $campaign_id = null;
    public $title = '';
    public $story = '';
    public $goal_amount = 50000;
    public $createdSlug = null;

    public function createP2p()
    {
        $this->validate([
            'title' => 'required|string|max:150',
            'story' => 'required|string|max:2000',
            'goal_amount' => 'required|numeric|min:1000',
        ]);

        $slug = Str::slug($this->title) . '-' . rand(100, 999);

        $p2p = P2pFundraiser::create([
            'user_id' => auth()->id(),
            'campaign_id' => $this->campaign_id,
            'title' => $this->title,
            'slug' => $slug,
            'story' => $this->story,
            'goal_amount' => $this->goal_amount,
            'raised_amount' => 0.00,
            'status' => 'active',
        ]);

        $this->createdSlug = $p2p->slug;
    }

    public function render()
    {
        $campaigns = Campaign::where('status', 'active')->get();
        return view('livewire.public.p2p-create', ['campaigns' => $campaigns])->layout('components.layouts.app');
    }
}
