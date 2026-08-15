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
        // Sanitize user inputs to prevent XSS & header injections
        $this->name = trim(strip_tags($this->name));
        $this->email = trim(strtolower($this->email));
        $this->phone = trim(strip_tags($this->phone));
        $this->subject = trim(strip_tags($this->subject));
        $this->message = trim(strip_tags($this->message));

        $this->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:25',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|min:5|max:2000',
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
