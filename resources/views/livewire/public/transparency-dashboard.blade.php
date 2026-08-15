<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if(!$isEnabled)
        <div class="max-w-2xl mx-auto my-12 bg-white dark:bg-slate-900 rounded-3xl p-12 text-center border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6">
            <div class="w-20 h-20 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-3xl">
                <i class="fa-solid fa-eye-slash"></i>
            </div>
            <h1 class="font-heading font-extrabold text-3xl text-slate-900 dark:text-white">Transparency Portal Offline</h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                The Public Transparency and Financial Audit module is currently offline for scheduled review or administration settings. Please check back later.
            </p>
            <div class="pt-4 flex justify-center gap-4">
                <a href="{{ route('home') }}" class="px-6 py-3 rounded-2xl bg-emerald-600 text-white font-bold text-xs shadow-lg">Return to Home</a>
                <a href="{{ route('public.contact') }}" class="px-6 py-3 rounded-2xl bg-slate-800 text-white font-bold text-xs">Contact Foundation</a>
            </div>
        </div>
    @else
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase tracking-widest">
                100% Radical Transparency
            </span>
            <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2">Public Financial Transparency</h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-2">We believe in complete accountability. Track every shilling received and spent by Gusii All Stars Foundation.</p>
        </div>

    <!-- Financial Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl">
            <span class="text-xs font-bold text-slate-400 uppercase">Total Money Raised</span>
            <div class="text-3xl font-extrabold font-heading text-emerald-600 dark:text-emerald-400 mt-1">
                KES {{ number_format($summary['total_raised'], 2) }}
            </div>
            <span class="text-[10px] text-slate-500 font-semibold">{{ $summary['total_donations_count'] }} Completed Donations</span>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl">
            <span class="text-xs font-bold text-slate-400 uppercase">Total Program Expenses</span>
            <div class="text-3xl font-extrabold font-heading text-rose-600 dark:text-rose-400 mt-1">
                KES {{ number_format($summary['total_expenses'], 2) }}
            </div>
            <span class="text-[10px] text-slate-500 font-semibold">Direct Relief & Food Purchases</span>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl">
            <span class="text-xs font-bold text-slate-400 uppercase">Net Reserve Balance</span>
            <div class="text-3xl font-extrabold font-heading text-teal-600 dark:text-teal-400 mt-1">
                KES {{ number_format($summary['net_fund_balance'], 2) }}
            </div>
            <span class="text-[10px] text-slate-500 font-semibold">Audited Fund Balance</span>
        </div>
    </div>

    <!-- Expense Log Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-xl">
        <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white mb-6">Recent Expense Log & Proof Documents</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Expense Title</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Campaign</th>
                        <th class="py-3 px-4 text-right">Amount (KES)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($expenses as $exp)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="py-3 px-4 font-mono">{{ $exp->expense_date->format('Y-m-d') }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">{{ $exp->title }}</td>
                            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-bold">{{ $exp->category }}</span></td>
                            <td class="py-3 px-4 text-slate-500">{{ $exp->campaign->title ?? 'General Fund' }}</td>
                            <td class="py-3 px-4 text-right font-extrabold text-rose-600">KES {{ number_format($exp->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No public expenses recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
