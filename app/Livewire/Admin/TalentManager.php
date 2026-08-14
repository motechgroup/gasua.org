<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Talent;
use Illuminate\Support\Str;

class TalentManager extends Component
{
    public $talents;

    // Form fields
    public $talent_id = null;
    public $name = '';
    public $category = 'football';
    public $bio = '';
    public $profile_image = '';
    public $target_amount = 0;
    public $is_featured = true;

    public $isModalOpen = false;
    public $isEditing = false;

    public function render()
    {
        $this->talents = Talent::latest()->get();
        return view('livewire.admin.talent-manager')->layout('components.layouts.admin');
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
        $this->talent_id = null;
        $this->name = '';
        $this->category = 'football';
        $this->bio = '';
        $this->profile_image = '';
        $this->target_amount = 0;
        $this->is_featured = true;
    }

    public function edit($id)
    {
        $t = Talent::findOrFail($id);
        $this->talent_id = $t->id;
        $this->name = $t->name;
        $this->category = $t->category;
        $this->bio = $t->bio;
        $this->profile_image = $t->profile_image;
        $this->target_amount = $t->target_amount;
        $this->is_featured = (bool)$t->is_featured;

        $this->isEditing = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'bio' => 'required|string',
            'profile_image' => 'nullable|url',
        ]);

        Talent::updateOrCreate(
            ['id' => $this->talent_id],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'category' => $this->category,
                'bio' => $this->bio,
                'profile_image' => $this->profile_image,
                'target_amount' => $this->target_amount ?: 0,
                'is_featured' => $this->is_featured,
            ]
        );

        session()->flash('success', $this->isEditing ? 'Talent profile updated!' : 'New talent profile created!');
        $this->closeModal();
    }

    public function delete($id)
    {
        Talent::destroy($id);
        session()->flash('success', 'Talent profile deleted.');
    }
}
