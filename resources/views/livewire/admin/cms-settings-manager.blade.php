<div class="space-y-8">
    <div>
        <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">CMS, System & Deployment Settings</h2>
        <p class="text-xs text-slate-500">Update foundation info, impact metrics, and inspect GitHub commit status & database migrations.</p>
    </div>

    @if($saved)
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-xs font-bold flex justify-between items-center">
            <span><i class="fa-solid fa-circle-check mr-2"></i> Site settings and deployment configurations saved successfully!</span>
            <button @click="$wire.set('saved', false)" class="text-emerald-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Shared Hosting Git Deployer & Status Card -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-950 text-white rounded-3xl p-8 border border-slate-800 shadow-2xl space-y-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-extrabold uppercase tracking-widest border border-emerald-500/30">
                        Git Branch: origin/{{ $branchName }}
                    </span>
                    @if($latestCommitHash)
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 font-mono text-[10px] font-bold">
                            #{{ $latestCommitHash }}
                        </span>
                    @endif
                </div>
                <h3 class="font-heading font-bold text-xl text-white mt-2">GitHub Code Sync & Database Migrations</h3>
                @if($latestCommitMessage)
                    <p class="text-xs text-slate-300 mt-1 font-semibold">
                        <i class="fa-solid fa-code-commit text-emerald-400 mr-1"></i> Latest Commit: "{{ $latestCommitMessage }}"
                    </p>
                    <span class="block text-[11px] text-slate-400 mt-0.5">Committed by <strong>{{ $latestCommitAuthor }}</strong> on {{ $latestCommitDate }}</span>
                @else
                    <p class="text-xs text-slate-400 mt-1">Executes database migrations and configuration cache refresh on your server.</p>
                @endif
            </div>
            
            <button wire:click="runGitPullAndMigrate" wire:loading.attr="disabled" class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-extrabold text-xs shadow-xl shadow-emerald-500/20 hover:scale-105 transition-all flex items-center gap-2">
                <span wire:loading.remove><i class="fa-solid fa-cloud-arrow-down mr-1"></i> Sync Code & Run Migrations</span>
                <span wire:loading><i class="fa-solid fa-spinner fa-spin mr-1"></i> Executing Migrations & Sync...</span>
            </button>
        </div>

        @if(!empty($modifiedFiles))
            <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800/80 space-y-2">
                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Recently Changed Files in <code class="text-emerald-400">origin/{{ $branchName }}</code>:</span>
                <div class="flex flex-wrap gap-2 text-[11px] font-mono">
                    @foreach($modifiedFiles as $file)
                        <span class="px-2.5 py-1 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 flex items-center gap-1.5">
                            @if($file['status'] === 'added') <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            @elseif($file['status'] === 'modified') <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            @elseif($file['status'] === 'removed') <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            @else <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                            @endif
                            {{ $file['name'] }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

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
