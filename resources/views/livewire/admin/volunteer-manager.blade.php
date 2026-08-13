<div class="space-y-6">
    <div>
        <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">Volunteer Applications Pipeline</h2>
        <p class="text-xs text-slate-500">Review volunteer skillsets and approve or assign volunteers to foundation events.</p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                    <th class="py-3 px-4">Applicant</th>
                    <th class="py-3 px-4">Contact</th>
                    <th class="py-3 px-4">County</th>
                    <th class="py-3 px-4">Motivation</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($volunteers as $vol)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">{{ $vol->name }}</td>
                        <td class="py-3 px-4 text-slate-500">{{ $vol->email }}<br>{{ $vol->phone }}</td>
                        <td class="py-3 px-4 font-bold">{{ $vol->county }}</td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400 line-clamp-2 max-w-xs">{{ $vol->motivation }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $vol->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($vol->status === 'rejected' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ $vol->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            @if($vol->status === 'pending')
                                <button wire:click="approveVolunteer({{ $vol->id }})" class="px-3 py-1 rounded-xl bg-emerald-600 text-white font-bold text-[10px] mr-1">Approve</button>
                                <button wire:click="rejectVolunteer({{ $vol->id }})" class="px-3 py-1 rounded-xl bg-rose-600 text-white font-bold text-[10px]">Reject</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
