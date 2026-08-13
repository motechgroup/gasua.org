<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserManager extends Component
{
    public function assignRole($userId, $roleName)
    {
        $user = User::findOrFail($userId);
        $user->syncRoles([$roleName]);
    }

    public function render()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('components.layouts.admin', ['headerTitle' => 'User & Role Management (RBAC)']);
    }
}
