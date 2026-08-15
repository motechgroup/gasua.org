<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">User Accounts & RBAC Management</h2>
            <p class="text-xs text-slate-500">Manage user credentials, RBAC staff roles, and remove system accounts.</p>
        </div>

        <button wire:click="openCreateModal" class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg transition-all flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i> Add New User
        </button>
    </div>

    <!-- Flash Notifications -->
    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-xs font-bold flex justify-between items-center">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('message') }}</span>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950 text-rose-800 dark:text-rose-300 text-xs font-bold flex justify-between items-center border border-rose-200 dark:border-rose-800">
            <span><i class="fa-solid fa-triangle-exclamation mr-2"></i> {{ session('error') }}</span>
        </div>
    @endif

    <!-- Toolbar: Search Bar -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-4 border border-slate-200 dark:border-slate-800 shadow-lg">
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-xs"></i>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search users by name, email, or phone..." class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs focus:ring-2 focus:ring-emerald-500">
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                    <th class="py-3 px-4">User</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Phone</th>
                    <th class="py-3 px-4">Role</th>
                    <th class="py-3 px-4">Change Role</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($users as $u)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs uppercase shadow">
                                {{ strtoupper(substr($u->name, 0, 2)) }}
                            </div>
                            <div>
                                <span class="block">{{ $u->name }}</span>
                                @if($u->id === auth()->id())
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-400 font-extrabold uppercase">You (Current)</span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500">{{ $u->email }}</td>
                        <td class="py-3.5 px-4 font-mono">{{ $u->phone ?? 'N/A' }}</td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase">
                                {{ $u->roles->first()?->name ?? 'Supporter' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <select wire:change="assignRole({{ $u->id }}, $event.target.value)" class="px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold focus:outline-none">
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}" {{ $u->hasRole($r->name) ? 'selected' : '' }}>{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="openEditModal({{ $u->id }})" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-emerald-600 hover:text-white transition-colors" title="Edit User">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                @if($u->id !== auth()->id())
                                    <button wire:click="deleteUser({{ $u->id }})" wire:confirm="Are you sure you want to permanently delete user '{{ $u->name }}'?" class="p-2 rounded-xl bg-rose-50 dark:bg-rose-950 text-rose-600 hover:bg-rose-600 hover:text-white transition-colors" title="Delete User">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @else
                                    <span class="p-2 rounded-xl text-slate-300 dark:text-slate-700 cursor-not-allowed" title="Self-deletion prohibited">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">No users found matching your search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create User Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">Create New Staff User</h3>
                    <button wire:click="$set('showCreateModal', false)" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
                </div>

                <form wire:submit.prevent="createUser" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold mb-1">Full Name</label>
                        <input type="text" wire:model="name" placeholder="John Doe" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                        @error('name') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Email Address</label>
                        <input type="email" wire:model="email" placeholder="john@gusiiallstars.org" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                        @error('email') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold mb-1">Phone Number</label>
                            <input type="text" wire:model="phone" placeholder="+254 700 000 000" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                            @error('phone') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-bold mb-1">RBAC Role</label>
                            <select wire:model="role" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Password</label>
                        <input type="password" wire:model="password" placeholder="Minimum 8 characters" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                        @error('password') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" wire:click="$set('showCreateModal', false)" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold shadow">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Edit User Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">Edit User Account</h3>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
                </div>

                <form wire:submit.prevent="updateUser" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold mb-1">Full Name</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                        @error('name') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1">Email Address</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                        @error('email') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold mb-1">Phone Number</label>
                            <input type="text" wire:model="phone" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                            @error('phone') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-bold mb-1">RBAC Role</label>
                            <select wire:model="role" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold mb-1">New Password (leave blank to keep current)</label>
                        <input type="password" wire:model="password" placeholder="Enter new password if changing" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                        @error('password') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" wire:click="$set('showEditModal', false)" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold shadow">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
