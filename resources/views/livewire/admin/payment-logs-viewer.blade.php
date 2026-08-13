<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Payment & Webhook Audit Logs</h2>
            <p class="text-xs text-slate-500">Inspect raw HTTP callback payloads, STK Push logs, and manually retry failed webhooks.</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex gap-3 text-xs font-bold">
        <button wire:click="$set('activeTab', 'webhooks')" class="px-5 py-2.5 rounded-2xl border transition-all" :class="$wire.activeTab === 'webhooks' ? 'bg-emerald-600 text-white border-emerald-600 shadow' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300'">
            <i class="fa-solid fa-webhook mr-1"></i> Webhook Callback Logs ({{ $webhookLogs->count() }})
        </button>
        <button wire:click="$set('activeTab', 'payments')" class="px-5 py-2.5 rounded-2xl border transition-all" :class="$wire.activeTab === 'payments' ? 'bg-emerald-600 text-white border-emerald-600 shadow' : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300'">
            <i class="fa-solid fa-list-check mr-1"></i> Gateway API Request Logs ({{ $paymentLogs->count() }})
        </button>
    </div>

    @if($activeTab === 'webhooks')
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                        <th class="py-3 px-4">Time</th>
                        <th class="py-3 px-4">Gateway</th>
                        <th class="py-3 px-4">Event Type</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Retries</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($webhookLogs as $wh)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="py-3 px-4 text-slate-500">{{ $wh->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="py-3 px-4 font-bold uppercase text-emerald-600">{{ $wh->gateway_code }}</td>
                            <td class="py-3 px-4 text-slate-700 dark:text-slate-300">{{ $wh->event_type ?? 'callback' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $wh->status === 'processed' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $wh->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-500">{{ $wh->retry_count }}</td>
                            <td class="py-3 px-4 text-right">
                                <button wire:click="retryWebhook({{ $wh->id }})" class="px-3 py-1 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-emerald-600 text-white font-bold text-[10px] transition-colors">
                                    <i class="fa-solid fa-arrows-rotate mr-1"></i> Retry
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No webhook logs recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                        <th class="py-3 px-4">Time</th>
                        <th class="py-3 px-4">Donation Ref</th>
                        <th class="py-3 px-4">Gateway</th>
                        <th class="py-3 px-4">IP Address</th>
                        <th class="py-3 px-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($paymentLogs as $pl)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="py-3 px-4 text-slate-500">{{ $pl->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">{{ $pl->donation->transaction_reference ?? 'N/A' }}</td>
                            <td class="py-3 px-4 uppercase text-emerald-600 font-bold">{{ $pl->gateway_code }}</td>
                            <td class="py-3 px-4 text-slate-500">{{ $pl->ip_address }}</td>
                            <td class="py-3 px-4 text-right font-bold text-slate-900 dark:text-white uppercase">{{ $pl->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No payment logs recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
