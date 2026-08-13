<div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6">
        <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase">
            Personal Supporter Fundraiser
        </span>
        
        <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white">{{ $p2p->title }}</h1>
        <p class="text-xs text-slate-500">Organized by <strong>{{ $p2p->user->name ?? 'Supporter' }}</strong> for Gusii All Stars Foundation</p>

        <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-3">
            <div class="flex justify-between items-center text-xs font-bold">
                <span class="text-emerald-600 text-lg">Raised: KES {{ number_format($p2p->raised_amount, 2) }}</span>
                <span class="text-slate-500">Target: KES {{ number_format($p2p->goal_amount, 2) }}</span>
            </div>
            <div class="w-full h-3 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                <div class="h-full bg-emerald-500" style="width: {{ $p2p->progress_percentage }}%;"></div>
            </div>
        </div>

        <div class="prose dark:prose-invert text-xs sm:text-sm text-slate-600 dark:text-slate-300">
            {!! nl2br(e($p2p->story)) !!}
        </div>

        <a href="{{ route('public.donate', ['p2p' => $p2p->id]) }}" class="block w-full text-center py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs shadow-xl">
            Donate to {{ $p2p->user->name ?? 'Supporter' }}'s Fundraiser
        </a>
    </div>
</div>
