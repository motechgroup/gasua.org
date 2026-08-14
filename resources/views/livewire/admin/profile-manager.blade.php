<div class="p-6 sm:p-10 max-w-5xl mx-auto space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-3xl text-slate-900 dark:text-white">Account & Profile Settings</h1>
            <p class="text-xs text-slate-500 mt-1">Manage your account credentials, avatar, security, and password.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-bold flex items-center justify-center text-xl overflow-hidden shadow-lg">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                @endif
            </div>
            <div>
                <h3 class="font-heading font-bold text-sm text-slate-900 dark:text-white">{{ $user->name }}</h3>
                <span class="text-[10px] font-mono text-emerald-600 dark:text-emerald-400 font-bold uppercase">Super Administrator</span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex border-b border-slate-200 dark:border-slate-800 text-xs font-bold gap-8">
        <button wire:click="$set('activeTab', 'profile')" class="pb-3 border-b-2 transition-all flex items-center gap-2" :class="$wire.activeTab === 'profile' ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-extrabold' : 'border-transparent text-slate-400 hover:text-slate-600'">
            <i class="fa-solid fa-user-gear"></i> Profile Details
        </button>
        <button wire:click="$set('activeTab', 'password')" class="pb-3 border-b-2 transition-all flex items-center gap-2" :class="$wire.activeTab === 'password' ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-extrabold' : 'border-transparent text-slate-400 hover:text-slate-600'">
            <i class="fa-solid fa-key"></i> Change Password
        </button>
        <button wire:click="$set('activeTab', 'security')" class="pb-3 border-b-2 transition-all flex items-center gap-2" :class="$wire.activeTab === 'security' ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-extrabold' : 'border-transparent text-slate-400 hover:text-slate-600'">
            <i class="fa-solid fa-shield-halved"></i> Account Overview & Security
        </button>
    </div>

    <!-- TAB 1: PROFILE DETAILS -->
    <div x-show="$wire.activeTab === 'profile'" x-transition class="space-y-6">
        @if (session()->has('profile_success'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-bold">
                <i class="fa-solid fa-circle-check mr-2"></i> {{ session('profile_success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Personal & Contact Information</h3>

            <form wire:submit.prevent="updateProfile" class="space-y-6 text-xs">
                <div class="flex items-center gap-6 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-600 text-white font-bold flex items-center justify-center text-2xl overflow-hidden shadow">
                        @if($avatar)
                            <img src="{{ $avatar }}" alt="Preview" class="w-full h-full object-cover">
                        @else
                            <span>{{ strtoupper(substr($name ?: 'US', 0, 2)) }}</span>
                        @endif
                    </div>
                    <div class="flex-grow space-y-1">
                        <label class="block font-bold text-slate-700 dark:text-slate-300">Profile Avatar URL</label>
                        <input type="url" wire:model.live="avatar" placeholder="https://images.unsplash.com/photo-..." class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                        <p class="text-[10px] text-slate-400">Paste an image link for your custom avatar photo.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Full Name / Username <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="name" placeholder="Super Administrator" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        @error('name') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Email Address <span class="text-rose-500">*</span></label>
                        <input type="email" wire:model="email" placeholder="admin@gusiiallstars.org" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        @error('email') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Phone Number</label>
                    <input type="text" wire:model="phone" placeholder="+254 700 123 456" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    @error('phone') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg shadow-emerald-500/20">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TAB 2: CHANGE PASSWORD -->
    <div x-show="$wire.activeTab === 'password'" x-transition class="space-y-6">
        @if (session()->has('password_success'))
            <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-bold">
                <i class="fa-solid fa-circle-check mr-2"></i> {{ session('password_success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Security & Password Update</h3>

            <form wire:submit.prevent="updatePassword" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Current Password <span class="text-rose-500">*</span></label>
                    <input type="password" wire:model="current_password" placeholder="••••••••" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    @error('current_password') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">New Password <span class="text-rose-500">* (Min 8 Characters)</span></label>
                        <input type="password" wire:model="new_password" placeholder="••••••••" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        @error('new_password') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Confirm New Password <span class="text-rose-500">*</span></label>
                        <input type="password" wire:model="new_password_confirmation" placeholder="••••••••" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg shadow-emerald-500/20">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TAB 3: ACCOUNT OVERVIEW & SECURITY -->
    <div x-show="$wire.activeTab === 'security'" x-transition class="space-y-6">
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Account Status & Roles</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-1">
                    <span class="text-slate-400 font-bold uppercase text-[10px]">Account Role</span>
                    <strong class="block text-sm text-emerald-600 dark:text-emerald-400 font-bold uppercase">Super Admin</strong>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-1">
                    <span class="text-slate-400 font-bold uppercase text-[10px]">Member Since</span>
                    <strong class="block text-sm text-slate-900 dark:text-white font-mono">{{ $user->created_at->format('M d, Y') }}</strong>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-1">
                    <span class="text-slate-400 font-bold uppercase text-[10px]">Account Status</span>
                    <strong class="block text-sm text-emerald-600 font-bold uppercase">Active & Verified</strong>
                </div>
            </div>
        </div>
    </div>

</div>
