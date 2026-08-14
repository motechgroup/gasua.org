<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-xs font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Pillars of Impact</span>
        <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2">GASUA Foundation Programs</h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-3 leading-relaxed">
            Our core initiatives drive sustainable community development across Kisii and Nyamira Counties through youth talent nurturing, education bursaries, food hampers, and health outreach.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($programs as $prog)
            <div class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-xl hover:shadow-2xl transition-all flex flex-col justify-between group">
                <div>
                    <!-- Optional Banner or Image -->
                    <div class="relative h-48 bg-gradient-to-tr from-slate-900 via-emerald-950 to-slate-900 p-6 flex items-end overflow-hidden">
                        @if($prog->cover_image)
                            <img src="{{ $prog->cover_image }}" alt="{{ $prog->title }}" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/20 to-teal-500/10"></div>
                        @endif
                        <div class="relative z-10 flex items-center gap-3">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-2xl font-bold shadow-lg">
                                <i class="fa-solid fa-{{ $prog->icon ?: 'star' }}"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Program Content -->
                    <div class="p-8 space-y-4">
                        <h3 class="font-heading font-bold text-2xl text-slate-900 dark:text-white group-hover:text-emerald-600 transition-colors">
                            {{ $prog->title }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
                            {{ $prog->short_description }}
                        </p>

                        @if($prog->full_content)
                            <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 text-xs text-slate-500 dark:text-slate-400 space-y-2">
                                <span class="block font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider text-[10px]">Key Impact Deliverables:</span>
                                <p class="leading-relaxed">{!! nl2br(e($prog->full_content)) !!}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Action Button -->
                <div class="p-8 pt-0">
                    <a href="{{ route('public.donate', ['program' => $prog->id]) }}" class="w-full py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-extrabold text-xs shadow-xl shadow-emerald-500/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-heart text-rose-300"></i> Donate to This Program
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
