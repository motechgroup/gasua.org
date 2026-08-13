<div class="space-y-6">
    <div>
        <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Donations Ledger</h2>
        <p class="text-xs text-slate-500">Monitor live donations, inspect payment status, and verify offline payments.</p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                    <th class="py-3 px-4">Ref #</th>
                    <th class="py-3 px-4">Donor</th>
                    <th class="py-3 px-4">Campaign</th>
                    <th class="py-3 px-4">Gateway</th>
                    <th class="py-3 px-4">Amount</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($donations as $don)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="py-3 px-4 font-mono font-bold">{{ $don->transaction_reference }}</td>
                        <td class="py-3 px-4">
                            <strong class="block text-slate-900 dark:text-white">{{ $don->donor_name }}</strong>
                            <span class="text-[10px] text-slate-400">{{ $don->donor_email }}</span>
                        </td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300 font-medium">{{ $don->campaign->title ?? 'General Fund' }}</td>
                        <td class="py-3 px-4 font-bold uppercase text-emerald-600">{{ $don->gateway_code }}</td>
                        <td class="py-3 px-4 font-extrabold text-slate-900 dark:text-white">{{ $don->currency }} {{ number_format($don->amount, 2) }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $don->payment_status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $don->payment_status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            @if($don->payment_status !== 'completed')
                                <button wire:click="markAsCompleted({{ $don->id }})" class="px-3 py-1 rounded-xl bg-emerald-600 text-white font-bold text-[10px] hover:bg-emerald-500">
                                    Confirm Payment
                                </button>
                            @else
                                <span class="text-emerald-600 font-bold text-[10px]"><i class="fa-solid fa-check"></i> Verified</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
