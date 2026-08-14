<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileManager extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $avatar = '';

    // Password change fields
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // Active tab state
    public $activeTab = 'profile'; // profile, password, security

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone ?? '';
            $this->avatar = $user->avatar ?? '';
        }
    }

    public function updateProfile()
    {
        $user = auth()->user();

        $this->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'avatar' => 'nullable|url',
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
        ]);

        session()->flash('profile_success', 'Profile details updated successfully!');
    }

    public function updatePassword()
    {
        $user = auth()->user();

        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        session()->flash('password_success', 'Your password has been changed successfully!');
    }

    public function render()
    {
        return view('livewire.admin.profile-manager', [
            'user' => auth()->user(),
        ])->layout('components.layouts.admin');
    }
}
