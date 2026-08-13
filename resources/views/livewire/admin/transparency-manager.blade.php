<div class="space-y-8">
    <div>
        <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Public Transparency & Expense Logger</h2>
        <p class="text-xs text-slate-500">Record program disbursements and proof documents for public audit display.</p>
    </div>

    <!-- Record Expense Form -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg">
        <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white mb-4">Record New Expense</h3>
        <form wire:submit.prevent="createExpense" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
            <div>
                <label class="block font-bold mb-1">Expense Title</label>
                <input type="text" wire:model="title" placeholder="Purchase of Maize Flour" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border">
            </div>
            <div>
                <label class="block font-bold mb-1">Amount (KES)</label>
                <input type="number" wire:model="amount" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border">
            </div>
            <div>
                <label class="block font-bold mb-1">Date</label>
                <input type="date" wire:model="expense_date" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow">
                    Record Expense
                </button>
            </div>
        </form>
    </div>

    <!-- Expense List -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                    <th class="py-3 px-4">Date</th>
                    <th class="py-3 px-4">Title</th>
                    <th class="py-3 px-4">Category</th>
                    <th class="py-3 px-4 text-right">Amount (KES)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($expenses as $exp)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="py-3 px-4 font-mono">{{ $exp->expense_date->format('Y-m-d') }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">{{ $exp->title }}</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-bold">{{ $exp->category }}</span></td>
                        <td class="py-3 px-4 text-right font-extrabold text-rose-600">KES {{ number_format($exp->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
