<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Talent;

class TalentDirectory extends Component
{
    public $category = 'all';

    public function render()
    {
        $query = Talent::query();
        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        return view('livewire.public.talent-directory', [
            'talents' => $query->get(),
        ])->layout('components.layouts.app');
    }
}
