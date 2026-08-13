<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest">Stories of Impact</span>
        <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2">Latest News & Press Releases</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($articles as $art)
            <div class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-xl flex flex-col justify-between">
                <div class="p-6 space-y-3">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase">
                        {{ $art->category }}
                    </span>
                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">{{ $art->title }}</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">{{ $art->excerpt }}</p>
                </div>
                <div class="p-6 pt-0 text-xs font-bold text-slate-400 border-t border-slate-100 dark:border-slate-800 mt-4 flex justify-between">
                    <span>{{ $art->published_at ? $art->published_at->format('M d, Y') : 'Recent' }}</span>
                    <span><i class="fa-solid fa-eye mr-1"></i> {{ $art->views_count }} views</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
