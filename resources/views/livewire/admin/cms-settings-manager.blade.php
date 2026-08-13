<div class="space-y-8">
    <div>
        <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">CMS, System & Deployment Settings</h2>
        <p class="text-xs text-slate-500">Update general site info, impact counter metrics, and execute live GitHub code updates & database migrations on shared hosting.</p>
    </div>

    @if($saved)
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-xs font-bold flex justify-between items-center">
            <span><i class="fa-solid fa-circle-check mr-2"></i> Site settings and deployment configurations saved successfully!</span>
            <button @click="$wire.set('saved', false)" class="text-emerald-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Shared Hosting One-Click Deployment Box -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-950 text-white rounded-3xl p-8 border border-slate-800 shadow-2xl space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-extrabold uppercase tracking-widest border border-emerald-500/30">
                    Shared Hosting Git Deployer
                </span>
                <h3 class="font-heading font-bold text-xl text-white mt-2">Pull Latest GitHub Code & Run Migrations</h3>
                <p class="text-xs text-slate-400 mt-1">Executes <code class="text-emerald-400 font-mono">git pull origin main</code> and <code class="text-emerald-400 font-mono">php artisan migrate --force</code> on your shared server.</p>
            </div>
            
            <button wire:click="runGitPullAndMigrate" wire:loading.attr="disabled" class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-extrabold text-xs shadow-xl shadow-emerald-500/20 hover:scale-105 transition-all flex items-center gap-2">
                <span wire:loading.remove><i class="fa-solid fa-cloud-arrow-down mr-1"></i> Pull Code & Run Migrations</span>
                <span wire:loading><i class="fa-solid fa-spinner fa-spin mr-1"></i> Executing Git Pull & Migrations...</span>
            </button>
        </div>

        @if($deployOutput)
            <div class="p-6 rounded-2xl bg-slate-950 border border-slate-800 font-mono text-xs text-emerald-400 leading-relaxed overflow-x-auto whitespace-pre-wrap shadow-inner">
                {{ $deployOutput }}
            </div>
        @endif

        <div class="pt-4 border-t border-slate-800/80 space-y-2">
            <span class="block text-xs font-bold text-slate-400">Automated GitHub Webhook URL</span>
            <p class="text-[11px] text-slate-400">You can also configure GitHub repository webhooks to automatically trigger code pulls whenever you push to GitHub:</p>
            <div class="p-3 rounded-xl bg-slate-950 border border-slate-800 text-xs font-mono text-emerald-400 select-all">
                {{ url('/api/deploy/webhook') }}?secret={{ $deploy_secret }}
            </div>
        </div>
    </div>

    <!-- CMS General Settings Form -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-lg space-y-6">
        <form wire:submit.prevent="saveSettings" class="space-y-6 text-xs">
            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">General Foundation Info</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Foundation Name</label>
                    <input type="text" wire:model="site_name" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Contact Email</label>
                    <input type="email" wire:model="contact_email" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Contact Phone</label>
                    <input type="text" wire:model="contact_phone" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Deployment Webhook Secret Token</label>
                    <input type="text" wire:model="deploy_secret" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-mono">
                </div>
            </div>

            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white pt-4 border-t border-slate-100 dark:border-slate-800">Impact Counter Metrics</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Meals Served</label>
                    <input type="number" wire:model="impact_meals" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-bold text-emerald-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Children Sponsored</label>
                    <input type="number" wire:model="impact_children" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-bold text-teal-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Trees Planted</label>
                    <input type="number" wire:model="impact_trees" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-bold text-cyan-600">
                </div>
                <div>
                    <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Talents Nurtured</label>
                    <input type="number" wire:model="impact_talents" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-bold text-emerald-600">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">
                    Save Site Settings
                </button>
            </div>
        </form>
    </div>
</div>
