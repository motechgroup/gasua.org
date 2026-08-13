<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Volunteer;

class VolunteerRegister extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $county = 'Kisii';
    public $address = '';
    public $availability = 'Weekends & Events';
    public $motivation = '';
    public $skills = [];

    public $successMessage = false;

    public function registerVolunteer()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'motivation' => 'required|string|max:1000',
        ]);

        Volunteer::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'county' => $this->county,
            'address' => $this->address,
            'skills' => $this->skills,
            'availability' => $this->availability,
            'motivation' => $this->motivation,
            'status' => 'pending',
        ]);

        $this->successMessage = true;
    }

    public function render()
    {
        return view('livewire.public.volunteer-register')->layout('components.layouts.app');
    }
}
