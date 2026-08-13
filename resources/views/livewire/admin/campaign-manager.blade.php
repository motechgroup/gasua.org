<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Fundraising Campaigns</h2>
            <p class="text-xs text-slate-500">Create, monitor, and update campaigns for the foundation.</p>
        </div>
        <button wire:click="$set('showCreateModal', true)" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg">
            <i class="fa-solid fa-plus mr-1"></i> New Campaign
        </button>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                    <th class="py-3 px-4">Title</th>
                    <th class="py-3 px-4">Category</th>
                    <th class="py-3 px-4">Raised / Goal</th>
                    <th class="py-3 px-4">Donors</th>
                    <th class="py-3 px-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($campaigns as $c)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">{{ $c->title }}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-bold">{{ $c->category }}</span></td>
                        <td class="py-3 px-4 font-mono font-bold text-emerald-600">KES {{ number_format($c->raised_amount) }} / {{ number_format($c->goal_amount) }}</td>
                        <td class="py-3 px-4 font-bold">{{ $c->donors_count }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">{{ $c->status }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($showCreateModal)
        <div class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 max-w-xl w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-4">
                <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">Create New Campaign</h3>
                <form wire:submit.prevent="createCampaign" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold mb-1">Title</label>
                        <input type="text" wire:model="title" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                    </div>
                    <div>
                        <label class="block font-bold mb-1">Target Amount (KES)</label>
                        <input type="number" wire:model="goal_amount" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border">
                    </div>
                    <div>
                        <label class="block font-bold mb-1">Summary</label>
                        <textarea wire:model="summary" rows="2" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border"></textarea>
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" wire:click="$set('showCreateModal', false)" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold">Create Campaign</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
