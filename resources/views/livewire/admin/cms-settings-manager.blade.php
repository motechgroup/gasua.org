<div class="space-y-8">
    <div>
        <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">CMS & Homepage Impact Counters</h2>
        <p class="text-xs text-slate-500">Edit general foundation information, hero slogans, and live impact statistics counters.</p>
    </div>

    @if($saved)
        <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-bold">
            Site settings and impact metrics updated!
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-lg space-y-6">
        <form wire:submit.prevent="saveSettings" class="space-y-6 text-xs">
            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">General Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold mb-1">Foundation Name</label>
                    <input type="text" wire:model="site_name" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                </div>
                <div>
                    <label class="block font-bold mb-1">Contact Email</label>
                    <input type="email" wire:model="contact_email" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                </div>
                <div>
                    <label class="block font-bold mb-1">Contact Phone</label>
                    <input type="text" wire:model="contact_phone" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                </div>
            </div>

            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white pt-4 border-t border-slate-100 dark:border-slate-800">Impact Counter Metrics</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block font-bold mb-1">Meals Served</label>
                    <input type="number" wire:model="impact_meals" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border font-bold text-emerald-600">
                </div>
                <div>
                    <label class="block font-bold mb-1">Children Sponsored</label>
                    <input type="number" wire:model="impact_children" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border font-bold text-teal-600">
                </div>
                <div>
                    <label class="block font-bold mb-1">Trees Planted</label>
                    <input type="number" wire:model="impact_trees" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border font-bold text-cyan-600">
                </div>
                <div>
                    <label class="block font-bold mb-1">Talents Nurtured</label>
                    <input type="number" wire:model="impact_talents" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border font-bold text-emerald-600">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
