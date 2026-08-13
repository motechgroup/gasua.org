<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Campaign;
use Illuminate\Support\Str;

class CampaignManager extends Component
{
    public $showCreateModal = false;
    public $title = '';
    public $summary = '';
    public $description = '';
    public $goal_amount = 100000;
    public $category = 'Feeding';
    public $is_featured = false;
    public $is_emergency = false;

    public function createCampaign()
    {
        $this->validate([
            'title' => 'required|string|max:150',
            'summary' => 'required|string|max:500',
            'goal_amount' => 'required|numeric|min:1000',
        ]);

        Campaign::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . rand(100, 999),
            'summary' => $this->summary,
            'description' => $this->description,
            'goal_amount' => $this->goal_amount,
            'raised_amount' => 0.00,
            'category' => $this->category,
            'status' => 'active',
            'is_featured' => $this->is_featured,
            'is_emergency' => $this->is_emergency,
            'created_by' => auth()->id(),
        ]);

        $this->reset(['title', 'summary', 'description', 'showCreateModal']);
    }

    public function render()
    {
        $campaigns = Campaign::latest()->get();
        return view('livewire.admin.campaign-manager', ['campaigns' => $campaigns])
            ->layout('components.layouts.admin', ['headerTitle' => 'Campaign Management']);
    }
}
