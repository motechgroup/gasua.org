<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Program;
use Illuminate\Support\Str;

class ProgramManager extends Component
{
    public $programs;
    
    // Form fields
    public $program_id = null;
    public $title = '';
    public $icon = 'hand-holding-heart';
    public $short_description = '';
    public $full_content = '';
    public $cover_image = '';
    public $is_active = true;
    public $sort_order = 0;

    public $isModalOpen = false;
    public $isEditing = false;

    public function render()
    {
        $this->programs = Program::orderBy('sort_order', 'asc')->get();
        return view('livewire.admin.program-manager')->layout('components.layouts.admin');
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
        $this->program_id = null;
        $this->title = '';
        $this->icon = 'hand-holding-heart';
        $this->short_description = '';
        $this->full_content = '';
        $this->cover_image = '';
        $this->is_active = true;
        $this->sort_order = 0;
    }

    public function edit($id)
    {
        $prog = Program::findOrFail($id);
        $this->program_id = $prog->id;
        $this->title = $prog->title;
        $this->icon = $prog->icon ?: 'hand-holding-heart';
        $this->short_description = $prog->short_description;
        $this->full_content = $prog->full_content;
        $this->cover_image = $prog->cover_image;
        $this->is_active = (bool)$prog->is_active;
        $this->sort_order = $prog->sort_order;

        $this->isEditing = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'full_content' => 'nullable|string',
            'icon' => 'required|string|max:50',
            'cover_image' => 'nullable|url',
        ]);

        Program::updateOrCreate(
            ['id' => $this->program_id],
            [
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'icon' => $this->icon,
                'short_description' => $this->short_description,
                'full_content' => $this->full_content,
                'cover_image' => $this->cover_image,
                'is_active' => $this->is_active,
                'sort_order' => $this->sort_order,
            ]
        );

        session()->flash('success', $this->isEditing ? 'Program updated successfully!' : 'New program created successfully!');
        $this->closeModal();
    }

    public function toggleActive($id)
    {
        $prog = Program::findOrFail($id);
        $prog->is_active = !$prog->is_active;
        $prog->save();

        session()->flash('success', 'Program status updated.');
    }

    public function delete($id)
    {
        Program::destroy($id);
        session()->flash('success', 'Program deleted successfully.');
    }
}
