<div class="p-6 sm:p-10 space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-3xl text-slate-900 dark:text-white">Foundation Programs Manager</h1>
            <p class="text-xs text-slate-500 mt-1">Manage pillars of impact, upload descriptions, icons, and cover images.</p>
        </div>
        <button wire:click="openModal" class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-500/20 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add New Program
        </button>
    </div>

    @if (session()->has('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-bold">
            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Programs Grid / Table -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($programs as $prog)
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-xl flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-{{ $prog->icon ?: 'star' }}"></i>
                        </div>
                        <button wire:click="toggleActive({{ $prog->id }})" class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider {{ $prog->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-slate-100 text-slate-500 dark:bg-slate-800' }}">
                            {{ $prog->is_active ? 'Active' : 'Disabled' }}
                        </button>
                    </div>

                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">{{ $prog->title }}</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3">{{ $prog->short_description }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                    <button wire:click="edit({{ $prog->id }})" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-emerald-600 hover:text-white font-bold text-slate-700 dark:text-slate-300 transition-colors">
                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                    </button>
                    <button wire:click="delete({{ $prog->id }})" onclick="confirm('Are you sure you want to delete this program?') || event.stopImmediatePropagation()" class="text-rose-500 hover:text-rose-700 font-bold">
                        <i class="fa-solid fa-trash mr-1"></i> Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-500 text-xs">
                No programs created yet. Click "Add New Program" to create one.
            </div>
        @endforelse
    </div>

    <!-- Create / Edit Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-xl w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">
                        {{ $isEditing ? 'Edit Program' : 'Create New Program' }}
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Program Title <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="title" placeholder="e.g. High School Bursary Program" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        @error('title') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @error
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Icon (FontAwesome Name)</label>
                            <input type="text" wire:model="icon" placeholder="e.g. graduation-cap, kit-medical, seedling" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Sort Order</label>
                            <input type="number" wire:model="sort_order" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Short Summary <span class="text-rose-500">*</span></label>
                        <textarea wire:model="short_description" rows="2" placeholder="Brief program overview for cards..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700"></textarea>
                        @error('short_description') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Detailed Full Content</label>
                        <textarea wire:model="full_content" rows="4" placeholder="Detailed impact goals, targets, and milestones..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700"></textarea>
                    </div>

                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Cover Image URL (Optional)</label>
                        <input type="url" wire:model="cover_image" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <input type="checkbox" id="is_active" wire:model="is_active" class="rounded text-emerald-600 focus:ring-emerald-500">
                        <label for="is_active" class="font-bold text-slate-700 dark:text-slate-300">Program is Active & Visible Publicly</label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="closeModal" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold">Save Program</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
