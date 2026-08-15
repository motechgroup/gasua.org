<div class="space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Financial Statement & Gateway Analytics</h2>
            <p class="text-xs text-slate-500">Filter, inspect, and export comprehensive foundation revenue, gateway fees, and financial audits.</p>
        </div>

        <button wire:click="exportCsv" class="px-6 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-extrabold text-xs shadow-xl shadow-emerald-500/20 hover:scale-105 transition-all flex items-center gap-2">
            <i class="fa-solid fa-file-csv text-base"></i> Export Financial Report (CSV)
        </button>
    </div>

    <!-- Interactive Filters Toolbar -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg space-y-4">
        <h3 class="font-heading font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider">Report Filters</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-xs">
            <div>
                <label class="block font-bold mb-1 text-slate-600 dark:text-slate-400">Start Date</label>
                <input type="date" wire:model.live="start_date" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
            </div>

            <div>
                <label class="block font-bold mb-1 text-slate-600 dark:text-slate-400">End Date</label>
                <input type="date" wire:model.live="end_date" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
            </div>

            <div>
                <label class="block font-bold mb-1 text-slate-600 dark:text-slate-400">Payment Gateway</label>
                <select wire:model.live="selected_gateway" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    <option value="">All Gateways</option>
                    @foreach($availableGateways as $gw)
                        <option value="{{ $gw->code }}">{{ $gw->name }} ({{ strtoupper($gw->code) }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold mb-1 text-slate-600 dark:text-slate-400">Payment Status</label>
                <select wire:model.live="selected_status" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    <option value="">All Statuses</option>
                    <option value="completed">Completed / Successful</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed / Cancelled</option>
                </select>
            </div>

            <div class="flex items-end">
                <button wire:click="resetFilters" class="w-full py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 font-bold text-slate-700 dark:text-slate-300 transition-colors">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Reset Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Box -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <span class="text-xs font-bold text-slate-400 uppercase">Filtered Revenue</span>
            <div class="text-3xl font-extrabold font-heading text-emerald-600 dark:text-emerald-400 mt-1">KES {{ number_format($summary['total_raised'], 2) }}</div>
            <span class="text-[10px] text-slate-500 font-semibold mt-1 block">{{ number_format($summary['total_donations_count']) }} Total Records</span>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <span class="text-xs font-bold text-slate-400 uppercase">Program Expenses Disbursed</span>
            <div class="text-3xl font-extrabold font-heading text-rose-600 dark:text-rose-400 mt-1">KES {{ number_format($summary['total_expenses'], 2) }}</div>
            <span class="text-[10px] text-slate-500 font-semibold mt-1 block">Audit Proof Disbursements</span>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-lg">
            <span class="text-xs font-bold text-slate-400 uppercase">Net Reserve Fund</span>
            <div class="text-3xl font-extrabold font-heading text-teal-600 dark:text-teal-400 mt-1">KES {{ number_format($summary['net_fund_balance'], 2) }}</div>
            <span class="text-[10px] text-slate-500 font-semibold mt-1 block">Net Audited Balance</span>
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
                        <th class="py-3 px-4">Total Transactions</th>
                        <th class="py-3 px-4 text-right">Total Amount Collected</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($gatewayBreakdown as $gw)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="py-3 px-4 font-bold uppercase text-emerald-600">{{ $gw['gateway_code'] }}</td>
                            <td class="py-3 px-4 font-bold">{{ number_format($gw['total_count']) }}</td>
                            <td class="py-3 px-4 text-right font-extrabold text-slate-900 dark:text-white">KES {{ number_format($gw['total_amount'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-slate-400">No gateway transactions found for selected filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Filtered Transaction Ledger Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg space-y-4">
        <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Filtered Transaction Ledger</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                        <th class="py-3 px-4">Reference</th>
                        <th class="py-3 px-4">Donor Name</th>
                        <th class="py-3 px-4">Gateway</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4 text-right">Amount (KES)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($donations as $don)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900 dark:text-white">{{ $don->transaction_reference }}</td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold block text-slate-900 dark:text-white">{{ $don->donor_name }}</span>
                                <span class="text-[10px] text-slate-400">{{ $don->donor_email }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-[10px] font-bold uppercase">{{ $don->gateway_code }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($don->payment_status === 'completed')
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase">Completed</span>
                                @elseif($don->payment_status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300 text-[10px] font-extrabold uppercase">Pending</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-100 dark:bg-rose-950 text-rose-700 dark:text-rose-300 text-[10px] font-extrabold uppercase">{{ $don->payment_status }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono">{{ $don->created_at ? $don->created_at->format('Y-m-d H:i') : '' }}</td>
                            <td class="py-3.5 px-4 text-right font-extrabold text-emerald-600 dark:text-emerald-400">KES {{ number_format($don->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No transactions match your current filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-2">
            {{ $donations->links() }}
        </div>
    </div>
</div>
