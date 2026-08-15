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
        // Sanitize string inputs
        $this->name = trim(strip_tags($this->name));
        $this->email = trim(strtolower($this->email));
        $this->phone = trim(strip_tags($this->phone));
        $this->county = trim(strip_tags($this->county));
        $this->address = trim(strip_tags($this->address));
        $this->availability = trim(strip_tags($this->availability));
        $this->motivation = trim(strip_tags($this->motivation));

        $this->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:25',
            'county' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'motivation' => 'required|string|min:10|max:1000',
            'skills' => 'nullable|array',
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
