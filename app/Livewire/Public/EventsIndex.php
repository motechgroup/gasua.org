<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Event;

class EventsIndex extends Component
{
    public function render()
    {
        $events = Event::orderBy('event_date', 'asc')->get();
        return view('livewire.public.events-index', ['events' => $events])->layout('components.layouts.app');
    }
}
