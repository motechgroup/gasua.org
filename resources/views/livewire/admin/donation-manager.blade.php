<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Donations Ledger & Admin Control</h2>
            <p class="text-xs text-slate-500">Monitor live donations, inspect payment status, confirm pending transactions, or delete unwanted records.</p>
        </div>
    </div>

    <!-- Flash Notifications -->
    @if(session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-xs font-bold flex justify-between items-center">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('message') }}</span>
        </div>
    @endif

    <!-- Toolbar: Search Bar & Filters -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-4 border border-slate-200 dark:border-slate-800 shadow-lg grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-xs"></i>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by reference, donor name, email, or gateway..." class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs focus:ring-2 focus:ring-emerald-500">
        </div>

        <div>
            <select wire:model.live="status_filter" class="w-full px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold">
                <option value="">All Payment Statuses</option>
                <option value="completed">Completed / Verified</option>
                <option value="pending">Pending</option>
                <option value="failed">Failed</option>
            </select>
        </div>
    </div>

    <!-- Donations Table -->
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
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($donations as $don)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="py-3.5 px-4 font-mono font-bold text-slate-900 dark:text-white">{{ $don->transaction_reference }}</td>
                        <td class="py-3.5 px-4">
                            <strong class="block text-slate-900 dark:text-white">{{ $don->donor_name }}</strong>
                            <span class="text-[10px] text-slate-400">{{ $don->donor_email }}</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300 font-medium">{{ $don->campaign->title ?? 'General Fund' }}</td>
                        <td class="py-3.5 px-4 font-bold uppercase text-emerald-600">{{ $don->gateway_code }}</td>
                        <td class="py-3.5 px-4 font-extrabold text-slate-900 dark:text-white">{{ $don->currency }} {{ number_format($don->amount, 2) }}</td>
                        <td class="py-3.5 px-4">
                            @if($don->payment_status === 'completed')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase">
                                    Completed
                                </span>
                            @elseif($don->payment_status === 'pending')
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-950 text-amber-700 dark:text-amber-300 text-[10px] font-extrabold uppercase">
                                    Pending
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-rose-100 dark:bg-rose-950 text-rose-700 dark:text-rose-300 text-[10px] font-extrabold uppercase">
                                    {{ $don->payment_status }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($don->payment_status !== 'completed')
                                    <button wire:click="markAsCompleted({{ $don->id }})" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[10px] shadow transition-all">
                                        Confirm Payment
                                    </button>
                                @else
                                    <span class="text-emerald-600 dark:text-emerald-400 font-bold text-[10px] px-2 py-1 bg-emerald-50 dark:bg-emerald-950/50 rounded-lg">
                                        <i class="fa-solid fa-check"></i> Verified
                                    </span>
                                @endif

                                <button wire:click="deleteDonation({{ $don->id }})" wire:confirm="Are you sure you want to permanently delete donation reference '{{ $don->transaction_reference }}'?" class="p-2 rounded-xl bg-rose-50 dark:bg-rose-950 text-rose-600 hover:bg-rose-600 hover:text-white transition-colors" title="Delete Donation Record">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">No donations found matching your search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $donations->links() }}
        </div>
    </div>
</div>
