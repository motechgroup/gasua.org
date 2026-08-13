<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Volunteer;

class VolunteerManager extends Component
{
    public function approveVolunteer($id)
    {
        $v = Volunteer::findOrFail($id);
        $v->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);
    }

    public function rejectVolunteer($id)
    {
        $v = Volunteer::findOrFail($id);
        $v->update(['status' => 'rejected']);
    }

    public function render()
    {
        $volunteers = Volunteer::latest()->get();
        return view('livewire.admin.volunteer-manager', ['volunteers' => $volunteers])
            ->layout('components.layouts.admin', ['headerTitle' => 'Volunteer Coordinator']);
    }
}
