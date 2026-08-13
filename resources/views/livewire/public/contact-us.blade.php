<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold uppercase">
                Get In Touch
            </span>
            <h1 class="font-heading font-extrabold text-4xl text-slate-900 dark:text-white mt-2 mb-4">Contact Gusii All Stars Foundation</h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                Have questions about our programs, partnership opportunities, or donation channels? Send us a message or visit our foundation headquarters in Kisii Town.
            </p>

            <div class="space-y-6 text-xs font-semibold">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <strong class="block text-slate-900 dark:text-white text-sm">Headquarters</strong>
                        <span class="text-slate-500">Foundation House, Hospital Road, Kisii Town, Kenya</span>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-teal-100 dark:bg-teal-950 text-teal-600 dark:text-teal-400 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <strong class="block text-slate-900 dark:text-white text-sm">Phone Line</strong>
                        <span class="text-slate-500">+254 700 123 456 / +254 722 000 111</span>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-cyan-100 dark:bg-cyan-950 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <strong class="block text-slate-900 dark:text-white text-sm">Email Address</strong>
                        <span class="text-slate-500">info@gusiiallstars.org</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-2xl">
            @if($sent)
                <div class="p-6 rounded-2xl bg-emerald-50 dark:bg-emerald-950 border border-emerald-200 dark:border-emerald-800 text-center space-y-3">
                    <i class="fa-solid fa-circle-check text-4xl text-emerald-600"></i>
                    <h3 class="font-bold text-lg text-emerald-900 dark:text-emerald-200">Message Sent!</h3>
                    <p class="text-xs text-emerald-800 dark:text-emerald-300">Thank you for reaching out. We will get back to you shortly.</p>
                </div>
            @else
                <form wire:submit.prevent="sendMessage" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold mb-1">Your Name</label>
                            <input type="text" wire:model="name" placeholder="John Doe" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        </div>
                        <div>
                            <label class="block font-bold mb-1">Your Email</label>
                            <input type="email" wire:model="email" placeholder="john@example.com" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        </div>
                    </div>

                    <div class="text-xs">
                        <label class="block font-bold mb-1">Subject</label>
                        <input type="text" wire:model="subject" placeholder="Inquiry regarding..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    </div>

                    <div class="text-xs">
                        <label class="block font-bold mb-1">Message</label>
                        <textarea wire:model="message" rows="4" placeholder="How can we help you?" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs shadow-xl">
                        Send Message
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
