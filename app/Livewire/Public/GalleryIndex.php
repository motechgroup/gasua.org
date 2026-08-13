<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\GalleryItem;

class GalleryIndex extends Component
{
    public function render()
    {
        $gallery = GalleryItem::latest()->get();
        return view('livewire.public.gallery-index', ['gallery' => $gallery])->layout('components.layouts.app');
    }
}
