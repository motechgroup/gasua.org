<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="font-heading font-extrabold text-3xl text-slate-900 dark:text-white">My Donation History</h1>
            <p class="text-xs text-slate-500">Track your contributions, active recurring subscriptions, and official tax receipts.</p>
        </div>
        <a href="{{ route('public.donate') }}" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg">
            <i class="fa-solid fa-heart mr-1"></i> Make New Donation
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-xl overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                    <th class="py-3 px-4">Date</th>
                    <th class="py-3 px-4">Ref #</th>
                    <th class="py-3 px-4">Campaign / Cause</th>
                    <th class="py-3 px-4">Gateway</th>
                    <th class="py-3 px-4">Amount</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Receipt</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($donations as $don)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="py-3 px-4 font-mono">{{ $don->created_at->format('Y-m-d H:i') }}</td>
                        <td class="py-3 px-4 font-mono font-bold">{{ $don->transaction_reference }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">{{ $don->campaign->title ?? 'General Fund' }}</td>
                        <td class="py-3 px-4 uppercase font-semibold text-emerald-600">{{ $don->gateway_code }}</td>
                        <td class="py-3 px-4 font-extrabold text-slate-900 dark:text-white">{{ $don->currency }} {{ number_format($don->amount, 2) }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $don->payment_status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $don->payment_status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            @if($don->payment_status === 'completed')
                                <a href="{{ route('receipts.download', $don->transaction_reference) }}" target="_blank" class="px-3 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-emerald-600 hover:text-white font-bold text-[10px] transition-colors">
                                    <i class="fa-solid fa-download mr-1"></i> PDF
                                </a>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">No donation records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
