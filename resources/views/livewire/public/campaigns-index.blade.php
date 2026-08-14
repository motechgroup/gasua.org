<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="text-xs font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Fundraising Initiatives</span>
        <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2">Active Fundraising Campaigns</h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-2">Browse active relief campaigns, school bursary drives, and athletic development funds.</p>
    </div>

    <!-- Search & Filter Controls -->
    <div class="flex flex-col sm:flex-row gap-4 mb-10 max-w-2xl mx-auto">
        <div class="relative flex-grow">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search campaigns..." class="w-full pl-11 pr-4 py-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-sm">
        </div>
        <select wire:model.live="category" class="px-4 py-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-sm">
            <option value="all">All Categories</option>
            <option value="Feeding">Feeding & Relief</option>
            <option value="Education">Education Bursaries</option>
            <option value="Talent">Talent Development</option>
            <option value="Emergency">Emergency Relief</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($campaigns as $campaign)
            <div class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-xl hover:shadow-2xl transition-all flex flex-col justify-between group">
                <div>
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $campaign->cover_image ?? 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-emerald-600 text-white text-[10px] font-extrabold uppercase tracking-wider shadow">
                            {{ $campaign->category }}
                        </span>
                    </div>

                    <div class="p-6">
                        <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white line-clamp-2 mb-2 group-hover:text-emerald-600 transition-colors">
                            <a href="{{ route('public.campaigns.show', $campaign->slug) }}">{{ $campaign->title }}</a>
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">{{ $campaign->summary }}</p>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 dark:border-slate-800/80 mt-2">
                    <a href="{{ route('public.donate', ['campaign' => $campaign->id]) }}" class="w-full py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-heart text-rose-300"></i> Donate Now
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-500 text-xs">
                No active campaigns found matching your search.
            </div>
        @endforelse
    </div>
</div>
