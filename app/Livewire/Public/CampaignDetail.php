<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Campaign;
use App\Models\CampaignComment;

class CampaignDetail extends Component
{
    public Campaign $campaign;

    // Comment Form
    public $comment_name = '';
    public $comment_email = '';
    public $comment_text = '';
    public $commentSuccess = false;

    public function mount($slug)
    {
        $this->campaign = Campaign::with(['updates', 'comments', 'donations'])->where('slug', $slug)->firstOrFail();
    }

    public function postComment()
    {
        $this->validate([
            'comment_name' => 'required|string|max:100',
            'comment_text' => 'required|string|max:1000',
        ]);

        CampaignComment::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => $this->comment_name,
            'donor_email' => $this->comment_email,
            'comment' => $this->comment_text,
            'is_approved' => true,
        ]);

        $this->comment_name = '';
        $this->comment_email = '';
        $this->comment_text = '';
        $this->commentSuccess = true;
        $this->campaign->refresh();
    }

    public function render()
    {
        return view('livewire.public.campaign-detail')->layout('components.layouts.app');
    }
}
