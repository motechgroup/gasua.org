<div class="space-y-6">
    <div>
        <h2 class="font-heading font-extrabold text-2xl text-slate-900 dark:text-white">User Accounts & RBAC Roles</h2>
        <p class="text-xs text-slate-500">Assign staff roles (Super Admin, Campaign Manager, Content Manager, Finance Officer, Volunteer Coordinator).</p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-lg overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-400 font-bold uppercase">
                    <th class="py-3 px-4">User</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Phone</th>
                    <th class="py-3 px-4">Current Role</th>
                    <th class="py-3 px-4 text-right">Assign Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($users as $u)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">{{ $u->name }}</td>
                        <td class="py-3 px-4 text-slate-500">{{ $u->email }}</td>
                        <td class="py-3 px-4 font-mono">{{ $u->phone ?? 'N/A' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase">
                                {{ $u->roles->first()?->name ?? 'Supporter' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <select wire:change="assignRole({{ $u->id }}, $event.target.value)" class="px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-semibold">
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}" {{ $u->hasRole($r->name) ? 'selected' : '' }}>{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
