<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\NewsArticle;

class NewsIndex extends Component
{
    public function render()
    {
        $articles = NewsArticle::where('status', 'published')->latest('published_at')->get();
        return view('livewire.public.news-index', ['articles' => $articles])->layout('components.layouts.app');
    }
}
