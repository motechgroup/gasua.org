<div class="py-16 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 sm:p-12 border border-slate-200 dark:border-slate-800 shadow-2xl">
        <div class="text-center mb-8">
            <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase tracking-widest">
                Join Our Movement
            </span>
            <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-2">Become a Foundation Volunteer</h1>
            <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">Lend your skills, time, and heart to change lives across Kisii and Nyamira.</p>
        </div>

        @if($successMessage)
            <div class="p-6 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-center space-y-4">
                <i class="fa-solid fa-circle-check text-4xl text-emerald-600"></i>
                <h3 class="font-heading font-bold text-2xl text-emerald-900 dark:text-emerald-200">Application Submitted!</h3>
                <p class="text-xs text-emerald-800 dark:text-emerald-300">Thank you for registering. Our Volunteer Coordinator will review your application and contact you soon.</p>
            </div>
        @else
            <form wire:submit.prevent="registerVolunteer" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold mb-1">Full Name</label>
                        <input type="text" wire:model="name" placeholder="Mary Nyaboke" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        @error('name') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-bold mb-1">Email Address</label>
                        <input type="email" wire:model="email" placeholder="mary@example.com" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        @error('email') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold mb-1">Phone Number</label>
                        <input type="text" wire:model="phone" placeholder="0700123456" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        @error('phone') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-bold mb-1">County / Location</label>
                        <input type="text" wire:model="county" placeholder="Kisii or Nyamira" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-1 text-xs">Why do you want to volunteer with Gusii All Stars?</label>
                    <textarea wire:model="motivation" rows="3" placeholder="Share your motivation and skills..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs"></textarea>
                    @error('motivation') <span class="text-rose-500 text-[10px]">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs shadow-xl transition-colors">
                    Submit Volunteer Application
                </button>
            </form>
        @endif
    </div>
</div>
