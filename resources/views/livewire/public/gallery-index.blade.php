<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest">Media Showcase</span>
        <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2">Photo & Video Gallery</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($gallery as $item)
            <div class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-xl p-4">
                <div class="h-48 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-image text-3xl"></i>
                </div>
                <h4 class="font-heading font-bold text-sm text-slate-900 dark:text-white mt-3">{{ $item->title }}</h4>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 text-slate-400 text-xs">
                Photos and videos will be uploaded soon.
            </div>
        @endforelse
    </div>
</div>
