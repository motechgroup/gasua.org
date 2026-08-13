<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\ContactMessage;

class ContactUs extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $message = '';
    public $sent = false;

    public function sendMessage()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => 'unread',
        ]);

        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.public.contact-us')->layout('components.layouts.app');
    }
}
