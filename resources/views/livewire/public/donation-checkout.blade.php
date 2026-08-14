<div class="py-16 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    @if($isSuccess && $activeDonation)
        <!-- SUCCESS STATE & RECEIPT DOWNLOAD -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 sm:p-12 border border-emerald-200 dark:border-emerald-800 shadow-2xl text-center">
            <div class="w-20 h-20 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-4xl font-bold mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-check"></i>
            </div>
            
            <h2 class="font-heading font-extrabold text-3xl text-slate-900 dark:text-white mb-2">Thank You For Your Generosity!</h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Your donation has been verified and applied to our foundation funds.</p>

            <div class="max-w-md mx-auto bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-6 mb-8 text-left text-xs space-y-2 border border-slate-200 dark:border-slate-700">
                <div class="flex justify-between">
                    <span class="text-slate-500">Transaction Reference:</span>
                    <strong class="text-slate-900 dark:text-white font-mono">{{ $activeDonation->transaction_reference }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Receipt #:</span>
                    <strong class="text-emerald-600 dark:text-emerald-400 font-mono">{{ $activeDonation->receipt_number }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Amount Paid:</span>
                    <strong class="text-slate-900 dark:text-white font-bold text-sm">{{ $activeDonation->currency }} {{ number_format($activeDonation->amount, 2) }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Payment Gateway:</span>
                    <span class="uppercase font-bold text-emerald-600">{{ $activeDonation->gateway_code }}</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('receipts.download', $activeDonation->transaction_reference) }}" target="_blank" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-file-pdf"></i> Download Official PDF Receipt
                </a>
                <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                    Return to Homepage
                </a>
            </div>
        </div>

    @else

        <!-- DONATION CHECKOUT FORM -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-10 border border-slate-200 dark:border-slate-800 shadow-2xl">
            
            <div class="text-center mb-8">
                <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase tracking-widest">
                    Secure 256-Bit SSL Checkout
                </span>
                <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-2">Make a Direct Donation</h1>
                
                @if($selectedCampaign)
                    <div class="mt-4 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-800 dark:text-emerald-300 font-semibold">
                        <i class="fa-solid fa-bullhorn mr-2"></i> Supporting Campaign: <strong>{{ $selectedCampaign->title }}</strong>
                    </div>
                @elseif($selectedTalent)
                    <div class="mt-4 p-4 rounded-2xl bg-teal-50 dark:bg-teal-950/50 border border-teal-200 dark:border-teal-800 text-xs text-teal-800 dark:text-teal-300 font-semibold">
                        <i class="fa-solid fa-star mr-2"></i> Sponsoring Talent: <strong>{{ $selectedTalent->name }}</strong>
                    </div>
                @endif
            </div>

            @if($errorMessage)
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-xs font-semibold">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ $errorMessage }}
                </div>
            @endif

            <form wire:submit.prevent="processDonation" class="space-y-8">
                
                <!-- 1. Frequency Selection -->
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-500 mb-3">Donation Frequency</label>
                    <div class="grid grid-cols-3 gap-3 text-xs font-bold">
                        <button type="button" @click="$wire.set('is_recurring', false)" class="py-3 px-4 rounded-2xl border text-center transition-all" :class="!$wire.is_recurring ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700'">
                            One-Time
                        </button>
                        <button type="button" @click="$wire.set('is_recurring', true); $wire.set('recurring_frequency', 'monthly')" class="py-3 px-4 rounded-2xl border text-center transition-all" :class="$wire.is_recurring && $wire.recurring_frequency === 'monthly' ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700'">
                            Monthly Recurring
                        </button>
                        <button type="button" @click="$wire.set('is_recurring', true); $wire.set('recurring_frequency', 'annual')" class="py-3 px-4 rounded-2xl border text-center transition-all" :class="$wire.is_recurring && $wire.recurring_frequency === 'annual' ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700'">
                            Annual Recurring
                        </button>
                    </div>
                </div>

                <!-- 2. Preset Amounts -->
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-xs font-extrabold uppercase text-slate-500">Select Donation Amount</label>
                        <div class="flex gap-2 text-xs">
                            <button type="button" @click="$wire.set('currency', 'KES')" class="px-2.5 py-1 rounded-lg font-bold" :class="$wire.currency === 'KES' ? 'bg-slate-900 text-white dark:bg-slate-100 dark:text-slate-900' : 'text-slate-500'">KES (KSh)</button>
                            <button type="button" @click="$wire.set('currency', 'USD')" class="px-2.5 py-1 rounded-lg font-bold" :class="$wire.currency === 'USD' ? 'bg-slate-900 text-white dark:bg-slate-100 dark:text-slate-900' : 'text-slate-500'">USD ($)</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-3 mb-3 text-sm font-bold">
                        @foreach([500, 1000, 2500, 5000, 10000] as $preset)
                            <button type="button" wire:click="selectAmount({{ $preset }})" class="py-3 rounded-2xl border text-center transition-all" :class="$wire.amount == {{ $preset }} && !$wire.custom_amount ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700'">
                                {{ $currency }} {{ number_format($preset) }}
                            </button>
                        @endforeach
                    </div>

                    <input type="number" wire:model.live="custom_amount" placeholder="Or enter custom amount..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <!-- 3. Payment Gateway Selection -->
                <div>
                    <label class="block text-xs font-extrabold uppercase text-slate-500 mb-3">Choose Payment Gateway</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($gateways as $gw)
                            <label class="relative flex items-center p-4 rounded-2xl border cursor-pointer transition-all" :class="$wire.gateway_code === '{{ $gw->code }}' ? 'bg-emerald-50/60 dark:bg-emerald-950/60 border-emerald-500 shadow-md ring-2 ring-emerald-500/20' : 'bg-slate-50 dark:bg-slate-800/60 border-slate-200 dark:border-slate-700'">
                                <input type="radio" wire:model.live="gateway_code" value="{{ $gw->code }}" class="sr-only">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-lg text-emerald-600">
                                        @if($gw->code === 'mpesa') <i class="fa-solid fa-mobile-screen"></i>
                                        @elseif($gw->code === 'flutterwave') <i class="fa-solid fa-credit-card"></i>
                                        @elseif($gw->code === 'dpo') <i class="fa-solid fa-globe"></i>
                                        @elseif($gw->code === 'paypal') <i class="fa-brands fa-paypal"></i>
                                        @elseif($gw->code === 'nowpayments') <i class="fa-brands fa-bitcoin"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="block text-xs font-extrabold text-slate-900 dark:text-white">{{ $gw->name }}</span>
                                        <span class="block text-[10px] text-slate-500">{{ $gw->fee_percentage > 0 ? $gw->fee_percentage.'% fee' : 'Zero Fee' }}</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Donor Personal Details -->
                <div class="space-y-4 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <h4 class="font-heading font-bold text-sm text-slate-900 dark:text-white">Donor Details</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Full Name</label>
                            <input type="text" wire:model="donor_name" placeholder="John Doe" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            @error('donor_name') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Email Address (For PDF Receipt)</label>
                            <input type="email" wire:model="donor_email" placeholder="john@example.com" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            @error('donor_email') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Phone Number (Required for M-Pesa STK Push)</label>
                            <input type="text" wire:model="donor_phone" placeholder="0712345678 or 2547..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            @error('donor_phone') <span class="text-rose-500 text-[10px] mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700 dark:text-slate-300">Country</label>
                            <input type="text" wire:model="donor_country" placeholder="Kenya" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold mb-1 text-xs text-slate-700 dark:text-slate-300">Encouragement Message (Optional)</label>
                        <textarea wire:model="donor_message" rows="2" placeholder="Leave a message for the foundation or campaign..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="anonymous" wire:model="is_anonymous" class="rounded text-emerald-600 focus:ring-emerald-500">
                        <label for="anonymous" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Make this donation anonymous on public leaderboards</label>
                    </div>
                </div>

                <!-- 5. Payment Modal / Instructions Output (If initiated) -->
                @if($paymentResult)
                    <div class="p-6 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-xs">
                        <h4 class="font-bold text-emerald-900 dark:text-emerald-300 mb-2"><i class="fa-solid fa-circle-info mr-1"></i> Payment Instructions</h4>
                        <p class="text-emerald-800 dark:text-emerald-200 mb-4">{{ $paymentResult['instructions'] ?? '' }}</p>

                        @if(!empty($paymentResult['crypto_address']))
                            <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border font-mono text-center mb-4">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Official Wallet Address ({{ $paymentResult['crypto_currency'] }})</span>
                                <strong class="text-xs select-all text-emerald-600">{{ $paymentResult['crypto_address'] }}</strong>
                            </div>
                        @endif

                        @if($gateway_code === 'mpesa')
                            <div class="flex items-center gap-3">
                                <button type="button" wire:click="checkMpesaStatus" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-500 transition-colors">
                                    <i class="fa-solid fa-arrows-rotate mr-1"></i> Check STK Push Status
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Submit Button -->
                <button type="submit" wire:loading.attr="disabled" class="w-full py-4 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-extrabold text-sm shadow-xl shadow-emerald-500/25 transition-all flex items-center justify-center gap-2">
                    <span wire:loading.remove><i class="fa-solid fa-heart mr-1"></i> Complete Donation of {{ $currency }} {{ number_format(!empty($custom_amount) ? $custom_amount : $amount, 2) }}</span>
                    <span wire:loading><i class="fa-solid fa-spinner fa-spin mr-1"></i> Initiating Payment Gateway...</span>
                </button>

            </form>
        </div>

    @endif

</div>
