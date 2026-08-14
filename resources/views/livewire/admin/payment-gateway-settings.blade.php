<div class="space-y-8">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Payment Gateway Management</h2>
            <p class="text-xs text-slate-500">Enable or disable payment gateways, configure encrypted API keys, and toggle Sandbox/Live modes.</p>
        </div>
    </div>

    @if($savedMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-xs font-bold flex justify-between items-center">
            <span><i class="fa-solid fa-circle-check mr-2"></i> Payment gateway credentials updated successfully!</span>
            <button @click="$wire.set('savedMessage', false)" class="text-emerald-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Gateway List Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($gateways as $gw)
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg space-y-4 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 font-bold flex items-center justify-center text-lg">
                                @if($gw->code === 'mpesa') <img src="{{ asset('mpesa-logo.webp') }}" alt="M-Pesa" class="h-6 w-auto object-contain">
                                @elseif($gw->code === 'paypal') <img src="{{ asset('paypal.png') }}" alt="PayPal" class="h-6 w-auto object-contain">
                                @elseif($gw->code === 'stripe') <img src="{{ asset('stripe-logo.webp') }}" alt="Stripe" class="h-6 w-auto object-contain">
                                @elseif($gw->code === 'flutterwave') <i class="fa-solid fa-credit-card"></i>
                                @elseif($gw->code === 'dpo') <i class="fa-solid fa-globe"></i>
                                @elseif($gw->code === 'nowpayments') <i class="fa-brands fa-bitcoin text-amber-500"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-heading font-bold text-base text-slate-900 dark:text-white">{{ $gw->name }}</h3>
                                <span class="text-[10px] font-mono text-slate-400 uppercase">Code: {{ $gw->code }}</span>
                            </div>
                        </div>

                        <!-- Toggle Switch -->
                        <button wire:click="toggleGatewayStatus('{{ $gw->code }}')" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $gw->is_enabled ? 'bg-emerald-600' : 'bg-slate-300 dark:bg-slate-700' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $gw->is_enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </div>

                    <div class="flex items-center gap-2 text-[10px] font-bold mt-2">
                        <span class="px-2 py-0.5 rounded-md {{ $gw->is_enabled ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                            {{ $gw->is_enabled ? 'ENABLED' : 'DISABLED' }}
                        </span>
                        <span class="px-2 py-0.5 rounded-md {{ $gw->is_test_mode ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $gw->is_test_mode ? 'SANDBOX / TEST' : 'LIVE PRODUCTION' }}
                        </span>
                        @if($gw->is_default)
                            <span class="px-2 py-0.5 rounded-md bg-purple-100 text-purple-700">DEFAULT</span>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold">
                    <button wire:click="editGateway('{{ $gw->code }}')" class="px-4 py-2 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-emerald-600 text-white transition-colors">
                        <i class="fa-solid fa-key mr-1"></i> Credentials & Settings
                    </button>
                    @if(!$gw->is_default)
                        <button wire:click="setDefault('{{ $gw->code }}')" class="text-slate-400 hover:text-emerald-600">
                            Make Default
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Edit Modal / Drawer -->
    @if($editingCode)
        <div class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 max-w-2xl w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">Configure {{ $name }}</h3>
                    <button wire:click="$set('editingCode', null)" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
                </div>

                <form wire:submit.prevent="saveGateway" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold mb-1">Display Name</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    </div>

                    <div class="flex items-center gap-6 py-2">
                        <label class="flex items-center gap-2 cursor-pointer font-bold">
                            <input type="checkbox" wire:model="is_enabled" class="rounded text-emerald-600"> Enable Gateway
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer font-bold">
                            <input type="checkbox" wire:model="is_test_mode" class="rounded text-amber-600"> Test / Sandbox Mode
                        </label>
                    </div>

                    <div class="space-y-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                        <h4 class="font-bold text-sm text-slate-900 dark:text-white">API Key Credentials (Encrypted)</h4>
                        @foreach($credentials as $key => $val)
                            <div>
                                <label class="block font-mono text-[10px] text-slate-500 uppercase font-bold mb-1">{{ str_replace('_', ' ', $key) }}</label>
                                <input type="text" wire:model="credentials.{{ $key }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-mono">
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" wire:click="$set('editingCode', null)" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow">Save Credentials</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
