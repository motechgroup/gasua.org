<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest">Pillars of Transformation</span>
        <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2">Foundation Programs</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($programs as $prog)
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-{{ $prog->icon ?? 'star' }}"></i>
                </div>
                <h3 class="font-heading font-bold text-2xl text-slate-900 dark:text-white">{{ $prog->title }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $prog->full_content ?? $prog->short_description }}</p>
            </div>
        @endforeach
    </div>
</div>
