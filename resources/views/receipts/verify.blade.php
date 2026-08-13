@extends('components.layouts.app')

@section('content')
<div class="py-16 max-w-2xl mx-auto px-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-emerald-200 dark:border-emerald-800 shadow-2xl text-center space-y-6">
        <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center text-3xl mx-auto font-bold">
            <i class="fa-solid fa-shield-check"></i>
        </div>

        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase tracking-widest">
                VERIFIED OFFICIAL RECEIPT ✓
            </span>
            <h1 class="font-heading font-extrabold text-3xl text-slate-900 dark:text-white mt-2">Authentic Donation Receipt</h1>
            <p class="text-xs text-slate-500 mt-1">Issued by Gusii All Stars Foundation</p>
        </div>

        <div class="bg-slate-50 dark:bg-slate-800/60 p-6 rounded-2xl text-left text-xs space-y-2 font-mono">
            <div class="flex justify-between">
                <span class="text-slate-400">Receipt #:</span>
                <strong class="text-emerald-600">{{ $receipt->receipt_number }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Transaction Ref:</span>
                <strong class="text-slate-900 dark:text-white">{{ $donation->transaction_reference }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Donor Name:</span>
                <strong class="text-slate-900 dark:text-white">{{ $donation->donor_name }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Amount:</span>
                <strong class="text-emerald-600 text-sm font-extrabold">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Payment Gateway:</span>
                <span class="uppercase text-slate-900 dark:text-white">{{ $donation->gateway_code }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Date Issued:</span>
                <span class="text-slate-900 dark:text-white">{{ $donation->created_at->format('M d, Y H:i T') }}</span>
            </div>
        </div>

        <a href="{{ route('receipts.download', $donation->transaction_reference) }}" class="inline-block px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-lg">
            <i class="fa-solid fa-file-pdf mr-1"></i> Download PDF Receipt Copy
        </a>
    </div>
</div>
@endsection
