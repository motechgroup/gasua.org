<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': darkMode }" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- High-Ranking SEO Title & Description -->
    <title>{{ $title ?? 'GASUA - Gusii All Stars Foundation Kenya | Empowering Talents & Community Relief' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'GASUA (Gusii All Stars Foundation Kenya) is a registered non-profit charity foundation dedicated to youth talent development, food relief hampers, school bursaries, and community empowerment in Kisii & Nyamira.' }}">
    <meta name="keywords" content="GASUA, Gusii All Stars Foundation, GASUA Kenya, GASUA Charity, Kisii Foundation, Nyamira Charity, Youth Talent Sponsorship Kenya, M-Pesa Charity Donation, Non-Profit Organization Kisii, Food Relief Kenya">
    <meta name="author" content="Gusii All Stars Foundation Kenya">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Social Media Sharing -->
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? 'GASUA - Gusii All Stars Foundation Kenya' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'GASUA (Gusii All Stars Foundation Kenya) empowers youth talents, feeds vulnerable families, and provides education bursaries across Kisii and Nyamira.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="GASUA | Gusii All Stars Foundation Kenya">
    <meta property="og:image" content="{{ asset('mpesa-logo.webp') }}">

    <!-- Twitter Card Metadata -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="GASUA - Gusii All Stars Foundation Kenya">
    <meta name="twitter:description" content="Empowering youth talents, feeding vulnerable families, and sponsoring bright students in Kisii & Nyamira Counties.">

    <!-- Schema.org JSON-LD Structured Data for Google Ranking -->
    <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'NGO',
      'name' => 'GASUA',
      'alternateName' => 'Gusii All Stars Foundation Kenya',
      'url' => 'https://gasua.org',
      'logo' => asset('mpesa-logo.webp'),
      'description' => 'Registered non-profit charity foundation dedicated to nurturing youth talent, food relief hampers, and school bursaries in Kisii and Nyamira, Kenya.',
      'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Kisii Town',
        'addressRegion' => 'Kisii County',
        'addressCountry' => 'KE',
      ],
      'contactPoint' => [
        '@type' => 'ContactPoint',
        'telephone' => '+254700123456',
        'contactType' => 'customer support',
        'areaServed' => 'KE',
        'availableLanguage' => ['English', 'Swahili'],
      ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome / Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind & Alpine Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, .font-heading { font-family: 'Outfit', sans-serif; }
        .glass-panel { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); }
        .dark .glass-panel { background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col antialiased transition-colors duration-300">

    <!-- Flash Toast Notifications -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-20 right-5 z-50 flex items-center p-4 mb-4 text-emerald-800 bg-emerald-50 dark:bg-emerald-950 dark:text-emerald-300 rounded-2xl shadow-xl border border-emerald-200 dark:border-emerald-800 transition-all">
            <i class="fa-solid fa-circle-check text-xl mr-3 text-emerald-600"></i>
            <div class="text-sm font-semibold">{{ session('success') }}</div>
            <button @click="show = false" class="ml-4 text-emerald-600 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
        </div>
    @endif

    <!-- Top Info Bar -->
    <div class="bg-emerald-900 text-emerald-100 text-xs py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-6">
                <span><i class="fa-solid fa-phone mr-1.5 text-emerald-400"></i> +254 700 123 456</span>
                <span><i class="fa-solid fa-envelope mr-1.5 text-emerald-400"></i> info@gusiiallstars.org</span>
                <span class="hidden sm:inline"><i class="fa-solid fa-location-dot mr-1.5 text-emerald-400"></i> Kisii Town, Kenya</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('public.transparency') }}" class="hover:text-emerald-300 transition-colors"><i class="fa-solid fa-chart-pie mr-1"></i> Public Transparency</a>
                <span class="text-emerald-700">|</span>
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="hover:text-emerald-300 transition-colors flex items-center gap-1">
                    <i class="fa-solid" :class="darkMode ? 'fa-sun text-amber-400' : 'fa-moon text-slate-300'"></i>
                    <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 glass-panel border-b border-slate-200/80 dark:border-slate-800/80 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo: GASUA (G★ Logo) -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-500 to-emerald-400 flex items-center justify-center text-white font-black shadow-lg shadow-emerald-500/25 group-hover:scale-105 transition-transform relative">
                        <span class="font-heading text-2xl font-black tracking-tight drop-shadow-sm">G</span>
                        <i class="fa-solid fa-star text-[10px] text-amber-300 absolute top-1.5 right-1.5"></i>
                    </div>
                    <span class="font-heading font-black text-2xl sm:text-3xl tracking-wider bg-gradient-to-r from-emerald-700 via-teal-600 to-emerald-500 dark:from-emerald-400 dark:to-teal-300 bg-clip-text text-transparent">GASUA</span>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-6 text-sm font-semibold text-slate-700 dark:text-slate-200">
                    <a href="{{ route('home') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Home</a>
                    <a href="{{ route('public.about') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">About</a>
                    <a href="{{ route('public.programs') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Programs</a>
                    <a href="{{ route('public.talents') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Talents</a>
                    <a href="{{ route('public.campaigns') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Campaigns</a>
                    <a href="{{ route('public.events') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Events</a>
                    <a href="{{ route('public.gallery') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Gallery</a>
                    <a href="{{ route('public.volunteer') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Volunteer</a>
                    <a href="{{ route('public.contact') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Contact</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <span class="text-xs font-semibold max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 z-50 text-xs font-semibold">
                                @can('manage-campaigns')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-800 text-emerald-600 dark:text-emerald-400"><i class="fa-solid fa-gauge mr-2"></i> Admin Panel</a>
                                @endcan
                                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-800"><i class="fa-solid fa-id-badge mr-2 text-emerald-500"></i> My Profile</a>
                                <a href="{{ route('public.donor.dashboard') }}" class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-800"><i class="fa-solid fa-history mr-2"></i> Donor History</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950"><i class="fa-solid fa-right-from-bracket mr-2"></i> Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-emerald-600 transition-colors">Sign In</a>
                    @endauth

                    <a href="{{ route('public.donate') }}" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-bold text-xs tracking-wide shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-105 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-heart text-rose-300"></i> DONATE NOW
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex lg:hidden items-center gap-2" x-data="{ mobileOpen: false }">
                    <button @click="mobileOpen = !mobileOpen" class="p-2.5 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <i class="fa-solid" :class="mobileOpen ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                    </button>

                    <!-- Mobile Drawer -->
                    <div x-show="mobileOpen" x-transition class="fixed inset-x-0 top-20 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 p-6 shadow-2xl z-50 flex flex-col gap-4 font-semibold text-sm">
                        <a href="{{ route('home') }}" class="py-2 hover:text-emerald-600">Home</a>
                        <a href="{{ route('public.about') }}" class="py-2 hover:text-emerald-600">About Foundation</a>
                        <a href="{{ route('public.programs') }}" class="py-2 hover:text-emerald-600">Our Programs</a>
                        <a href="{{ route('public.talents') }}" class="py-2 hover:text-emerald-600">Talent Showcase</a>
                        <a href="{{ route('public.campaigns') }}" class="py-2 hover:text-emerald-600">Fundraising Campaigns</a>
                        <a href="{{ route('public.events') }}" class="py-2 hover:text-emerald-600">Upcoming Events</a>
                        <a href="{{ route('public.gallery') }}" class="py-2 hover:text-emerald-600">Gallery</a>
                        <a href="{{ route('public.volunteer') }}" class="py-2 hover:text-emerald-600">Volunteer</a>
                        <a href="{{ route('public.contact') }}" class="py-2 hover:text-emerald-600">Contact Us</a>
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-3">
                            <a href="{{ route('public.donate') }}" class="w-full text-center py-3 rounded-xl bg-emerald-600 text-white font-bold"><i class="fa-solid fa-heart mr-2"></i> Donate Now</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                
                <!-- Col 1: About -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center text-white font-black shadow-lg relative">
                            <span class="font-heading text-xl font-black tracking-tight">G</span>
                            <i class="fa-solid fa-star text-[8px] text-amber-300 absolute top-1.5 right-1.5"></i>
                        </div>
                        <span class="font-heading font-black text-2xl text-white tracking-wider">GASUA</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed mb-6">
                        GASUA (Gusii All Stars Foundation Kenya) is a registered non-profit charity organization dedicated to nurturing youth talents, feeding needy families, sponsoring education bursaries, and building community infrastructure across Kisii and Nyamira counties.
                    </p>
                    <div class="flex items-center gap-3 text-slate-400">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-xs transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-xs transition-colors"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-xs transition-colors"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-xs transition-colors"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-6">Quick Links</h4>
                    <ul class="space-y-3 text-xs">
                        <li><a href="{{ route('public.about') }}" class="hover:text-emerald-400 transition-colors"><i class="fa-solid fa-chevron-right text-[9px] mr-2 text-emerald-500"></i> About GASUA Foundation</a></li>
                        <li><a href="{{ route('public.campaigns') }}" class="hover:text-emerald-400 transition-colors"><i class="fa-solid fa-chevron-right text-[9px] mr-2 text-emerald-500"></i> Active Campaigns</a></li>
                        <li><a href="{{ route('public.talents') }}" class="hover:text-emerald-400 transition-colors"><i class="fa-solid fa-chevron-right text-[9px] mr-2 text-emerald-500"></i> Talent Directory</a></li>
                        <li><a href="{{ route('public.events') }}" class="hover:text-emerald-400 transition-colors"><i class="fa-solid fa-chevron-right text-[9px] mr-2 text-emerald-500"></i> Upcoming Events</a></li>
                        <li><a href="{{ route('public.transparency') }}" class="hover:text-emerald-400 transition-colors"><i class="fa-solid fa-chevron-right text-[9px] mr-2 text-emerald-500"></i> Financial Transparency</a></li>
                        <li><a href="{{ route('public.volunteer') }}" class="hover:text-emerald-400 transition-colors"><i class="fa-solid fa-chevron-right text-[9px] mr-2 text-emerald-500"></i> Become a Volunteer</a></li>
                    </ul>
                </div>

                <!-- Col 3: Programs -->
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-6">Pillars of Impact</h4>
                    <ul class="space-y-3 text-xs">
                        <li><a href="{{ route('public.programs') }}" class="hover:text-emerald-400 transition-colors">Youth Talent Development Academy</a></li>
                        <li><a href="{{ route('public.programs') }}" class="hover:text-emerald-400 transition-colors">School Meal Feeding Program</a></li>
                        <li><a href="{{ route('public.programs') }}" class="hover:text-emerald-400 transition-colors">Girl Child High School Bursaries</a></li>
                        <li><a href="{{ route('public.programs') }}" class="hover:text-emerald-400 transition-colors">Community Free Medical Outreach</a></li>
                        <li><a href="{{ route('public.programs') }}" class="hover:text-emerald-400 transition-colors">Youth Entrepreneurship Micro-Grants</a></li>
                    </ul>
                </div>

                <!-- Col 4: Newsletter -->
                <div>
                    <h4 class="font-heading font-bold text-white text-sm uppercase tracking-wider mb-6">Stay Updated</h4>
                    <p class="text-xs text-slate-400 mb-4">Subscribe to receive monthly GASUA foundation impact reports and campaign updates.</p>
                    <form action="#" method="POST" class="flex flex-col gap-2">
                        @csrf
                        <input type="email" placeholder="Enter your email address" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition-colors">Subscribe Now</button>
                    </form>
                </div>

            </div>

            <!-- Bottom Copyright & Payment Badges -->
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} GASUA (Gusii All Stars Foundation Kenya). All rights reserved. Built with excellence.</p>
                <div class="flex items-center gap-4 text-slate-400 text-lg">
                    <span class="text-xs font-semibold text-slate-500">Accepted Payments:</span>
                    <img src="{{ asset('mpesa-logo.webp') }}" alt="M-Pesa" class="h-5 w-auto object-contain">
                    <img src="{{ asset('stripe-logo.webp') }}" alt="Stripe" class="h-5 w-auto object-contain">
                    <img src="{{ asset('paypal.png') }}" alt="PayPal" class="h-5 w-auto object-contain font-bold">
                    <i class="fa-brands fa-bitcoin text-amber-500" title="Crypto NOWPayments"></i>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
