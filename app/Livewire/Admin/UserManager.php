<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateModal = false;
    public $showEditModal = false;

    // Form inputs
    public $editingUserId = null;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $role = 'Supporter';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'email', 'phone', 'password', 'editingUserId']);
        $this->role = 'Supporter';
        $this->showCreateModal = true;
    }

    public function createUser()
    {
        $this->name = trim(strip_tags($this->name));
        $this->email = trim(strtolower($this->email));
        $this->phone = trim(strip_tags($this->phone));
        $this->role = trim(strip_tags($this->role));

        $this->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:users,email|max:150',
            'phone' => 'nullable|string|max:25',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole($this->role);

        $this->showCreateModal = false;
        session()->flash('message', "User '{$this->name}' created successfully!");
    }

    public function openEditModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->role = $user->roles->first()?->name ?? 'Supporter';
        $this->password = '';
        $this->showEditModal = true;
    }

    public function updateUser()
    {
        $user = User::findOrFail($this->editingUserId);

        $this->name = trim(strip_tags($this->name));
        $this->email = trim(strtolower($this->email));
        $this->phone = trim(strip_tags($this->phone));
        $this->role = trim(strip_tags($this->role));

        $this->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:25',
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        $user->syncRoles([$this->role]);

        $this->showEditModal = false;
        session()->flash('message', "User '{$this->name}' updated successfully!");
    }

    public function assignRole($userId, $roleName)
    {
        $user = User::findOrFail($userId);
        $user->syncRoles([$roleName]);
        session()->flash('message', "Role for '{$user->name}' updated to {$roleName}.");
    }

    public function deleteUser($userId)
    {
        if ($userId == auth()->id()) {
            session()->flash('error', "Security Warning: You cannot delete your own logged-in account!");
            return;
        }

        $user = User::findOrFail($userId);
        $userName = $user->name;
        $user->delete();

        session()->flash('message', "User '{$userName}' deleted successfully.");
    }

    public function render()
    {
        $query = User::with('roles');

        if (!empty($this->search)) {
            $searchTerm = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm);
            });
        }

        $users = $query->latest()->paginate(15);
        $roles = Role::all();

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('components.layouts.admin', ['headerTitle' => 'User & Role Management (RBAC)']);
    }
}
