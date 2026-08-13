<div class="py-16 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 sm:p-12 border border-slate-200 dark:border-slate-800 shadow-2xl">
        <div class="text-center mb-8">
            <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase tracking-widest">
                Peer-to-Peer Social Fundraising
            </span>
            <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-2">Start Your Personal Fundraiser</h1>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">Raise funds from your friends, family, and network for Gusii All Stars Foundation causes!</p>
        </div>

        @if($createdSlug)
            <div class="p-6 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-center space-y-4">
                <i class="fa-solid fa-circle-check text-4xl text-emerald-600"></i>
                <h3 class="font-heading font-bold text-2xl text-emerald-900 dark:text-emerald-200">Your Fundraiser is Live!</h3>
                <p class="text-xs text-emerald-800 dark:text-emerald-300">Share your custom fundraising link with your network:</p>
                <div class="p-3 bg-white dark:bg-slate-900 rounded-xl border text-xs font-mono text-emerald-600 select-all">
                    {{ route('public.p2p.show', $createdSlug) }}
                </div>
                <a href="{{ route('public.p2p.show', $createdSlug) }}" class="inline-block px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold text-xs">
                    View Fundraiser Page
                </a>
            </div>
        @else
            <form wire:submit.prevent="createP2p" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold mb-1 text-slate-700 dark:text-slate-300">Parent Campaign (Optional)</label>
                    <select wire:model="campaign_id" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold">
                        <option value="">General Foundation Fund</option>
                        @foreach($campaigns as $c)
                            <option value="{{ $c->id }}">{{ $c->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1 text-slate-700 dark:text-slate-300">Fundraiser Title</label>
                    <input type="text" wire:model="title" placeholder="e.g. John's Birthday Giving for Gusii Orphans" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs">
                    @error('title') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1 text-slate-700 dark:text-slate-300">Fundraising Target (KES)</label>
                    <input type="number" wire:model="goal_amount" placeholder="50000" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs">
                    @error('goal_amount') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1 text-slate-700 dark:text-slate-300">Your Story / Message to Friends</label>
                    <textarea wire:model="story" rows="4" placeholder="Explain why you are raising funds for Gusii All Stars Foundation..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs"></textarea>
                    @error('story') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-extrabold text-xs shadow-xl transition-all">
                    Launch Personal Fundraiser Now
                </button>
            </form>
        @endif
    </div>
</div>
