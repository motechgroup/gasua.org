<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="text-xs font-extrabold text-teal-600 uppercase tracking-widest">Grassroots Stars</span>
        <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2">Gusii Talent Showcase Directory</h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-2">Discover and sponsor young footballers, athletes, vocalists, dancers, and actors.</p>
    </div>

    <!-- Category Filters -->
    <div class="flex flex-wrap justify-center gap-2 mb-10 text-xs font-bold">
        @foreach(['all' => 'All Talents', 'football' => 'Football', 'athletics' => 'Athletics', 'music' => 'Music & Singing', 'dance' => 'Dance', 'drama' => 'Drama & Comedy'] as $key => $label)
            <button wire:click="$set('category', '{{ $key }}')" class="px-4 py-2 rounded-2xl border transition-all" :class="$wire.category === '{{ $key }}' ? 'bg-emerald-600 text-white border-emerald-600 shadow' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300'">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($talents as $talent)
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-xl flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-teal-600 text-white font-bold flex items-center justify-center text-lg shadow uppercase">
                            {{ substr($talent->name, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">{{ $talent->name }}</h3>
                            <span class="px-2.5 py-0.5 rounded-full bg-teal-100 dark:bg-teal-950 text-teal-700 dark:text-teal-300 text-[10px] font-extrabold uppercase">
                                {{ $talent->category }}
                            </span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 mb-4 leading-relaxed">{{ $talent->bio }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs font-bold text-emerald-600">Raised: KES {{ number_format($talent->raised_amount) }}</span>
                    <a href="{{ route('public.donate', ['talent' => $talent->id]) }}" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-500">
                        Sponsor Talent
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
