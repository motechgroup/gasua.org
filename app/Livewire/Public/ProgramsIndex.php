<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Program;

class ProgramsIndex extends Component
{
    public function render()
    {
        $programs = Program::where('is_active', true)->orderBy('sort_order')->get();
        return view('livewire.public.programs-index', ['programs' => $programs])->layout('components.layouts.app');
    }
}
