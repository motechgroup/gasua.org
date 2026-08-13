<div class="space-y-8">
    
    <!-- Executive Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase">Total Revenue</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-slate-900 dark:text-white">
                KES {{ number_format($summary['total_raised'], 2) }}
            </div>
            <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold mt-1 block"><i class="fa-solid fa-arrow-trend-up mr-1"></i> {{ $summary['total_donations_count'] }} Total Donations</span>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase">Active Campaigns</span>
                <div class="w-10 h-10 rounded-2xl bg-teal-100 dark:bg-teal-950 text-teal-600 dark:text-teal-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-slate-900 dark:text-white">
                {{ $summary['total_campaigns'] }}
            </div>
            <span class="text-[10px] text-teal-600 dark:text-teal-400 font-bold mt-1 block">Live Fundraising Drives</span>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase">Active Volunteers</span>
                <div class="w-10 h-10 rounded-2xl bg-cyan-100 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-slate-900 dark:text-white">
                {{ $summary['active_volunteers'] }}
            </div>
            <span class="text-[10px] text-cyan-600 dark:text-cyan-400 font-bold mt-1 block">Approved Community Helpers</span>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase">Program Expenses</span>
                <div class="w-10 h-10 rounded-2xl bg-rose-100 dark:bg-rose-950 text-rose-600 dark:text-rose-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-heading text-slate-900 dark:text-white">
                KES {{ number_format($summary['total_expenses'], 2) }}
            </div>
            <span class="text-[10px] text-rose-600 dark:text-rose-400 font-bold mt-1 block">Audited Disbursed Funds</span>
        </div>
    </div>

    <!-- Active Campaigns & Recent Donations Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Completed Donations -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Recent Donations</h3>
                <a href="{{ route('admin.donations') }}" class="text-xs font-bold text-emerald-600 hover:underline">View All</a>
            </div>

            <div class="space-y-4">
                @foreach($recentDonations as $donation)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 font-bold flex items-center justify-center uppercase">
                                {{ substr($donation->donor_name, 0, 2) }}
                            </div>
                            <div>
                                <strong class="block text-slate-900 dark:text-white text-sm">{{ $donation->donor_name }}</strong>
                                <span class="text-[10px] text-slate-500">{{ $donation->campaign->title ?? 'General Fund' }} • {{ $donation->gateway_code }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <strong class="block text-emerald-600 dark:text-emerald-400 font-extrabold text-sm">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</strong>
                            <span class="text-[10px] text-slate-400">{{ $donation->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Active Campaigns Progress -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Campaign Performance</h3>
                <a href="{{ route('admin.campaigns') }}" class="text-xs font-bold text-emerald-600 hover:underline">Manage</a>
            </div>

            <div class="space-y-6">
                @foreach($activeCampaigns as $c)
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-900 dark:text-white line-clamp-1">{{ $c->title }}</span>
                            <span class="text-emerald-600">{{ number_format(($c->raised_amount / max(1,$c->goal_amount))*100, 1) }}%</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-emerald-500" style="width: {{ min(100, ($c->raised_amount / max(1,$c->goal_amount))*100) }}%;"></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-slate-400">
                            <span>Raised: KES {{ number_format($c->raised_amount) }}</span>
                            <span>Target: KES {{ number_format($c->goal_amount) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
