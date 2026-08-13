<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TransparencyExpense;
use App\Models\Campaign;

class TransparencyManager extends Component
{
    public $title = '';
    public $campaign_id = null;
    public $amount = 0;
    public $expense_date = '';
    public $description = '';
    public $category = 'Relief Supplies';

    public function createExpense()
    {
        $this->validate([
            'title' => 'required|string|max:150',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
        ]);

        TransparencyExpense::create([
            'title' => $this->title,
            'campaign_id' => $this->campaign_id,
            'amount' => $this->amount,
            'expense_date' => $this->expense_date,
            'description' => $this->description,
            'category' => $this->category,
        ]);

        $this->reset(['title', 'amount', 'description']);
    }

    public function render()
    {
        $expenses = TransparencyExpense::with('campaign')->latest()->get();
        $campaigns = Campaign::all();

        return view('livewire.admin.transparency-manager', [
            'expenses' => $expenses,
            'campaigns' => $campaigns,
        ])->layout('components.layouts.admin', ['headerTitle' => 'Public Transparency & Audit Manager']);
    }
}
