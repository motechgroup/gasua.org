<div class="space-y-8">
    <div>
        <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Financial Statement & Gateway Analytics</h2>
        <p class="text-xs text-slate-500">Comprehensive breakdown of all foundation revenue channels, gateway transaction fees, and net reserves.</p>
    </div>

    <!-- Summary Box -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <span class="text-xs font-bold text-slate-400 uppercase">Gross Revenue Received</span>
            <div class="text-3xl font-extrabold font-heading text-emerald-600 dark:text-emerald-400 mt-1">KES {{ number_format($summary['total_raised'], 2) }}</div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <span class="text-xs font-bold text-slate-400 uppercase">Program Expenses Disbursed</span>
            <div class="text-3xl font-extrabold font-heading text-rose-600 dark:text-rose-400 mt-1">KES {{ number_format($summary['total_expenses'], 2) }}</div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <span class="text-xs font-bold text-slate-400 uppercase">Net Reserve Fund</span>
            <div class="text-3xl font-extrabold font-heading text-teal-600 dark:text-teal-400 mt-1">KES {{ number_format($summary['net_fund_balance'], 2) }}</div>
        </div>
    </div>

    <!-- Gateway Distribution Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg">
        <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white mb-4">Revenue Collection Channel Breakdown</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                        <th class="py-3 px-4">Gateway Driver</th>
                        <th class="py-3 px-4">Total Successful Transactions</th>
                        <th class="py-3 px-4 text-right">Total Amount Collected</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($gatewayBreakdown as $gw)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="py-3 px-4 font-bold uppercase text-emerald-600">{{ $gw['gateway_code'] }}</td>
                            <td class="py-3 px-4 font-bold">{{ $gw['total_count'] }}</td>
                            <td class="py-3 px-4 text-right font-extrabold text-slate-900 dark:text-white">KES {{ number_format($gw['total_amount'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
