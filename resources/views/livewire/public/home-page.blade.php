<div>
    <!-- Hero Banner Section -->
    <section class="relative bg-slate-900 text-white min-h-[85vh] flex items-center justify-center overflow-hidden">
        <!-- Background Overlay Image / Gradient -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1920&q=80" alt="Gusii All Stars Foundation" class="w-full h-full object-cover opacity-20 filter brightness-90">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/80 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-widest mb-6 animate-pulse">
                <i class="fa-solid fa-heart-pulse"></i> Gusii All Stars Foundation Kenya
            </div>
            
            <h1 class="font-heading font-extrabold text-4xl sm:text-6xl lg:text-7xl tracking-tight leading-none mb-6">
                Nurturing Talents. <br class="hidden sm:inline">
                <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-400 bg-clip-text text-transparent">Transforming Lives in Gusii.</span>
            </h1>

            <p class="max-w-3xl mx-auto text-base sm:text-xl text-slate-300 font-normal leading-relaxed mb-10">
                Join us in building a brighter future. We scout youth talent, feed vulnerable households, sponsor education for bright students, and lead emergency relief initiatives across Kisii and Nyamira.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('public.donate') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold text-sm shadow-2xl shadow-emerald-500/30 hover:scale-105 transition-all flex items-center justify-center gap-3">
                    <i class="fa-solid fa-hand-holding-heart text-lg text-rose-300"></i> Make a Donation Now
                </a>
                <a href="{{ route('public.volunteer') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-slate-800/80 hover:bg-slate-700 text-white font-bold text-sm border border-slate-700 backdrop-blur-md hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-users-viewfinder text-emerald-400"></i> Become a Volunteer
                </a>
            </div>
        </div>
    </section>

    <!-- Impact Statistics Counter Bar -->
    <section class="relative z-20 -mt-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6 sm:p-8 rounded-3xl glass-panel shadow-2xl border border-slate-200/80 dark:border-slate-800">
            <div class="text-center p-4">
                <div class="text-3xl sm:text-4xl font-extrabold font-heading text-emerald-600 dark:text-emerald-400">{{ number_format($stats['meals']) }}+</div>
                <div class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mt-1">Meals Served</div>
            </div>
            <div class="text-center p-4 border-l border-slate-200 dark:border-slate-800">
                <div class="text-3xl sm:text-4xl font-extrabold font-heading text-teal-600 dark:text-teal-400">{{ number_format($stats['children']) }}+</div>
                <div class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mt-1">Children Sponsored</div>
            </div>
            <div class="text-center p-4 border-l border-slate-200 dark:border-slate-800">
                <div class="text-3xl sm:text-4xl font-extrabold font-heading text-cyan-600 dark:text-cyan-400">{{ number_format($stats['trees']) }}+</div>
                <div class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mt-1">Trees Planted</div>
            </div>
            <div class="text-center p-4 border-l border-slate-200 dark:border-slate-800">
                <div class="text-3xl sm:text-4xl font-extrabold font-heading text-emerald-600 dark:text-emerald-400">{{ number_format($stats['talents']) }}+</div>
                <div class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mt-1">Talents Nurtured</div>
            </div>
        </div>
    </section>

    <!-- Featured Urgent Campaigns -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4">
            <div>
                <span class="text-xs font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Urgent Fundraising</span>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-1">Featured Campaigns</h2>
            </div>
            <a href="{{ route('public.campaigns') }}" class="text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-2">
                View All Campaigns <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredCampaigns as $campaign)
                <div class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-xl hover:shadow-2xl transition-all group flex flex-col justify-between">
                    <div>
                        <!-- Cover Image -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $campaign->cover_image ?? 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-emerald-600 text-white text-[10px] font-extrabold uppercase tracking-wider shadow">
                                {{ $campaign->category }}
                            </span>
                            @if($campaign->is_emergency)
                                <span class="absolute top-4 right-4 px-3 py-1 rounded-full bg-rose-600 text-white text-[10px] font-extrabold uppercase tracking-wider shadow animate-bounce">
                                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Emergency
                                </span>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white line-clamp-2 mb-3 group-hover:text-emerald-600 transition-colors">
                                <a href="{{ route('public.campaigns.show', $campaign->slug) }}">{{ $campaign->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">
                                {{ $campaign->summary }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="p-6 pt-0 border-t border-slate-100 dark:border-slate-800/80 mt-4">
                        <a href="{{ route('public.donate', ['campaign' => $campaign->id]) }}" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-heart text-rose-300"></i> Donate Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Pillars of Impact Section -->
    <section class="py-20 bg-slate-100 dark:bg-slate-900/50 border-y border-slate-200/80 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Our Strategic Pillars</span>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-2">Comprehensive Foundation Programs</h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-3">From athletic academies to rural health camps, discover how Gusii All Stars Foundation creates sustainable community empowerment.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($programs as $program)
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200/80 dark:border-slate-800 shadow-lg hover:-translate-y-1 transition-all group">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                            <i class="fa-solid fa-{{ $program->icon ?? 'star' }}"></i>
                        </div>
                        <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white mb-3">{{ $program->title }}</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-6">{{ $program->short_description }}</p>
                        <a href="{{ route('public.programs') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline">Learn More <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i></a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Talent Development Showcase Carousel / Grid -->
    <section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4">
            <div>
                <span class="text-xs font-extrabold text-teal-600 dark:text-teal-400 uppercase tracking-widest">Nurturing Excellence</span>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-1">Featured Talents</h2>
            </div>
            <a href="{{ route('public.talents') }}" class="text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                Explore Talent Directory <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredTalents as $talent)
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-600 text-white font-bold flex items-center justify-center text-xl overflow-hidden shadow">
                                <span class="uppercase">{{ substr($talent->name, 0, 2) }}</span>
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-lg text-slate-900 dark:text-white">{{ $talent->name }}</h4>
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase">
                                    {{ $talent->category }}
                                </span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 mb-4 leading-relaxed">{{ $talent->bio }}</p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-600">Raised: KES {{ number_format($talent->raised_amount) }}</span>
                        <a href="{{ route('public.donate', ['talent' => $talent->id]) }}" class="px-4 py-2 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-emerald-600 text-white font-bold text-xs transition-colors">
                            Sponsor Talent
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Testimonial Stories -->
    <section class="py-20 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-extrabold text-emerald-400 uppercase tracking-widest">Transformative Stories</span>
                <h2 class="font-heading font-extrabold text-3xl sm:text-4xl mt-2">Voices of Impact</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($testimonials as $tst)
                    <div class="bg-slate-800/80 rounded-3xl p-8 border border-slate-700 relative">
                        <i class="fa-solid fa-quote-left text-4xl text-emerald-500/20 absolute top-6 right-6"></i>
                        <p class="text-xs sm:text-sm text-slate-300 italic mb-6 leading-relaxed">"{{ $tst->quote }}"</p>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr($tst->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-sm text-white">{{ $tst->name }}</h4>
                                <span class="text-[11px] text-emerald-400">{{ $tst->role_description }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
