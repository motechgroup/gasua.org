<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content (2 Cols) -->
        <div class="lg:col-span-2 space-y-8">
            <div>
                <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase tracking-wider">
                    {{ $campaign->category }}
                </span>
                <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-3">{{ $campaign->title }}</h1>
            </div>

            <!-- Main Cover Image -->
            <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 max-h-[450px]">
                <img src="{{ $campaign->cover_image ?? 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
            </div>

            <!-- Campaign Summary & Story -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-4">
                <h3 class="font-heading font-bold text-2xl text-slate-900 dark:text-white">About This Campaign</h3>
                <div class="prose dark:prose-invert text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    {!! nl2br(e($campaign->description)) !!}
                </div>
            </div>

            <!-- Updates Timeline -->
            @if($campaign->updates->count() > 0)
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                    <h3 class="font-heading font-bold text-2xl text-slate-900 dark:text-white"><i class="fa-solid fa-clock-rotate-left text-emerald-500 mr-2"></i> Campaign Updates ({{ $campaign->updates->count() }})</h3>
                    
                    <div class="space-y-6">
                        @foreach($campaign->updates as $update)
                            <div class="pl-4 border-l-4 border-emerald-500 space-y-2">
                                <div class="flex justify-between items-center text-xs">
                                    <h4 class="font-bold text-slate-900 dark:text-white text-sm">{{ $update->title }}</h4>
                                    <span class="text-slate-400">{{ $update->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $update->content }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Comments & Messages -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                <h3 class="font-heading font-bold text-2xl text-slate-900 dark:text-white"><i class="fa-solid fa-comments text-teal-500 mr-2"></i> Donor Words of Encouragement</h3>

                @if($commentSuccess)
                    <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-bold">
                        Thank you! Your message has been posted to the campaign page.
                    </div>
                @endif

                <form wire:submit.prevent="postComment" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <input type="text" wire:model="comment_name" placeholder="Your Name" class="px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <input type="email" wire:model="comment_email" placeholder="Your Email (Optional)" class="px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    </div>
                    <textarea wire:model="comment_text" rows="3" placeholder="Write a message of support..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs"></textarea>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-500">
                        Post Comment
                    </button>
                </form>

                <div class="space-y-4 pt-6 border-t border-slate-100 dark:border-slate-800">
                    @foreach($campaign->comments as $c)
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 text-xs space-y-1">
                            <div class="flex justify-between font-bold text-slate-900 dark:text-white">
                                <span>{{ $c->donor_name }}</span>
                                <span class="text-[10px] text-slate-400">{{ $c->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-300 italic">"{{ $c->comment }}"</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Actions (1 Col) -->
        <div class="space-y-8">
            <!-- Donation Progress Box -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-6 sticky top-28">
                <div>
                    <div class="text-3xl font-extrabold font-heading text-emerald-600 dark:text-emerald-400">
                        KES {{ number_format($campaign->raised_amount, 2) }}
                    </div>
                    <div class="text-xs font-semibold text-slate-500 mt-1">
                        raised of <strong>KES {{ number_format($campaign->goal_amount, 2) }}</strong> target
                    </div>
                </div>

                <div class="w-full h-3 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400" style="width: {{ $campaign->progress_percentage }}%;"></div>
                </div>

                <div class="flex justify-between text-xs font-bold text-slate-600 dark:text-slate-400 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <span><i class="fa-solid fa-users text-emerald-500 mr-1"></i> {{ $campaign->donors_count }} Donors</span>
                    <span><i class="fa-solid fa-chart-line text-emerald-500 mr-1"></i> {{ $campaign->progress_percentage }}% Funded</span>
                </div>

                <a href="{{ route('public.donate', ['campaign' => $campaign->id]) }}" class="w-full py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-extrabold text-xs shadow-xl shadow-emerald-500/25 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-heart text-rose-300"></i> DONATE TO THIS CAMPAIGN
                </a>

                <!-- Social Share Links -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Share This Campaign</span>
                    <div class="flex items-center gap-2">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($campaign->title . ' - Donate here: ' . request()->fullUrl()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm shadow hover:scale-105 transition-transform"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm shadow hover:scale-105 transition-transform"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($campaign->title) }}&url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-900 dark:bg-slate-700 text-white flex items-center justify-center text-sm shadow hover:scale-105 transition-transform"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
