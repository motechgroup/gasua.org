<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest">Community Gathering</span>
        <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2">Upcoming Events & Charity Walks</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($events as $event)
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-xl flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="px-4 py-2 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-extrabold text-xs text-center">
                            <span class="block text-lg font-heading">{{ $event->event_date->format('d') }}</span>
                            <span class="uppercase text-[9px]">{{ $event->event_date->format('M Y') }}</span>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">{{ $event->title }}</h3>
                            <span class="text-xs text-slate-500"><i class="fa-solid fa-location-dot text-emerald-500 mr-1"></i> {{ $event->location_name }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 mb-6 leading-relaxed">{{ $event->description }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold">
                    <span class="text-slate-500">Ticket: {{ $event->ticket_price > 0 ? 'KES '.number_format($event->ticket_price) : 'FREE ENTRY' }}</span>
                    <a href="{{ route('public.donate') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-500">
                        Support Event
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
