<div class="p-6 sm:p-10 space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="font-heading font-extrabold text-3xl text-slate-900 dark:text-white">Events Management</h1>
            <p class="text-xs text-slate-500 mt-1">Manage foundation charity walks, medical camps, and community gatherings.</p>
        </div>
        <button wire:click="openModal" class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg shadow-emerald-500/20 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Create New Event
        </button>
    </div>

    @if (session()->has('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-bold">
            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $ev)
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-xl flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-xs">
                        <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                            {{ $ev->status }}
                        </span>
                        <span class="font-mono text-slate-400 font-bold">
                            {{ $ev->event_date ? $ev->event_date->format('M d, Y') : 'Date TBD' }}
                        </span>
                    </div>

                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">{{ $ev->title }}</h3>
                    <p class="text-xs text-slate-500 font-semibold"><i class="fa-solid fa-location-dot mr-1 text-emerald-500"></i> {{ $ev->location_name }}</p>
                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 leading-relaxed">{{ $ev->description }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                    <button wire:click="edit({{ $ev->id }})" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-emerald-600 hover:text-white font-bold text-slate-700 dark:text-slate-300 transition-colors">
                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                    </button>
                    <button wire:click="delete({{ $ev->id }})" onclick="confirm('Are you sure you want to delete this event?') || event.stopImmediatePropagation()" class="text-rose-500 hover:text-rose-700 font-bold">
                        <i class="fa-solid fa-trash mr-1"></i> Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-500 text-xs">
                No events created yet. Click "Create New Event" to add one.
            </div>
        @endforelse
    </div>

    <!-- Create / Edit Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-xl w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">
                        {{ $isEditing ? 'Edit Event' : 'Create New Event' }}
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Event Title <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="title" placeholder="e.g. Gusii Annual Charity Walk 2026" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        @error('title') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Location Name <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="location_name" placeholder="e.g. Gusii Stadium, Kisii" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                            @error('location_name') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Event Date & Time <span class="text-rose-500">*</span></label>
                            <input type="datetime-local" wire:model="event_date" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Ticket Price (KES)</label>
                            <input type="number" wire:model="ticket_price" placeholder="0 for Free" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Event Status</label>
                            <select wire:model="status" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-bold">
                                <option value="upcoming">Upcoming</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Event Description</label>
                        <textarea wire:model="description" rows="3" placeholder="Overview of event goals, activities..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700"></textarea>
                    </div>

                    <div>
                        <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Cover Image URL (Optional)</label>
                        <input type="url" wire:model="cover_image" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" wire:click="closeModal" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
