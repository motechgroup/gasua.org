<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Str;

class EventManager extends Component
{
    public $events;

    // Form fields
    public $event_id = null;
    public $title = '';
    public $description = '';
    public $location_name = '';
    public $address = '';
    public $event_date = '';
    public $ticket_price = 0;
    public $cover_image = '';
    public $status = 'upcoming';

    public $isModalOpen = false;
    public $isEditing = false;

    public function render()
    {
        $this->events = Event::orderBy('event_date', 'desc')->get();
        return view('livewire.admin.event-manager')->layout('components.layouts.admin');
    }

    public function openModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
        $this->isEditing = false;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->event_id = null;
        $this->title = '';
        $this->description = '';
        $this->location_name = '';
        $this->address = '';
        $this->event_date = date('Y-m-d\TH:i');
        $this->ticket_price = 0;
        $this->cover_image = '';
        $this->status = 'upcoming';
    }

    public function edit($id)
    {
        $ev = Event::findOrFail($id);
        $this->event_id = $ev->id;
        $this->title = $ev->title;
        $this->description = $ev->description;
        $this->location_name = $ev->location_name;
        $this->address = $ev->address;
        $this->event_date = $ev->event_date ? $ev->event_date->format('Y-m-d\TH:i') : '';
        $this->ticket_price = $ev->ticket_price;
        $this->cover_image = $ev->cover_image;
        $this->status = $ev->status;

        $this->isEditing = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'location_name' => 'required|string|max:255',
            'event_date' => 'required',
            'ticket_price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|url',
        ]);

        Event::updateOrCreate(
            ['id' => $this->event_id],
            [
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'location_name' => $this->location_name,
                'address' => $this->address ?: $this->location_name,
                'event_date' => $this->event_date,
                'ticket_price' => $this->ticket_price ?: 0,
                'cover_image' => $this->cover_image,
                'status' => $this->status,
            ]
        );

        session()->flash('success', $this->isEditing ? 'Event updated successfully!' : 'New event created successfully!');
        $this->closeModal();
    }

    public function delete($id)
    {
        Event::destroy($id);
        session()->flash('success', 'Event deleted successfully.');
    }
}
