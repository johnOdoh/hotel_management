@component('layouts.guest', ['title' => 'Terms of Service — Grand Horizon Hotel & Suites'])
    <div x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }" class="min-h-screen transition-colors duration-300" style="background-color: var(--hotel-bg); color: var(--hotel-text);">

        {{-- ========================================== --}}
        {{-- TOP NAVIGATION --}}
        {{-- ========================================== --}}
        <nav class="sticky top-0 z-50 shadow-md border-b transition-colors duration-300" style="background: rgba(15, 23, 42, 0.96); backdrop-filter: blur(20px); border-color: rgba(212,168,83,0.2);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-110 shadow-lg" style="background: linear-gradient(135deg, #d4a853, #e8c878);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-white font-playfair text-lg font-semibold tracking-wide block">Grand Horizon</span>
                            <span class="hidden sm:block text-[10px] tracking-[0.25em] uppercase font-medium" style="color: #d4a853;">Hotel & Suites</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-4 sm:gap-6">
                        <a href="{{ route('home') }}" class="text-xs sm:text-sm font-medium text-white/80 hover:text-white transition-colors">Home</a>
                        <a href="{{ route('home') }}#rooms" class="text-xs sm:text-sm font-medium text-white/80 hover:text-white transition-colors">Rooms</a>
                        <a href="{{ route('privacy') }}" class="text-xs sm:text-sm font-medium text-white/80 hover:text-white transition-colors">Privacy Policy</a>

                        {{-- Dark Mode Toggle --}}
                        <button @click="toggleDarkMode()" class="p-2 rounded-full border text-white/80 hover:text-white transition-all duration-300 hover:scale-105" style="border-color: rgba(212,168,83,0.35); background: rgba(255,255,255,0.08);" title="Toggle Dark/Light Mode" aria-label="Toggle theme">
                            <svg x-show="!darkMode" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                            <svg x-show="darkMode" x-cloak class="w-4 h-4 sm:w-5 sm:h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </button>

                        {{-- User Auth / Dropdown Menu --}}
                        <x-hotel-auth-menu />
                    </div>
                </div>
            </div>
        </nav>

        {{-- ========================================== --}}
        {{-- HEADER BANNER --}}
        {{-- ========================================== --}}
        <header class="relative py-16 sm:py-20 overflow-hidden" style="background: var(--hotel-navy);">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="inline-block py-1 px-4 rounded-full text-xs font-semibold tracking-[0.25em] uppercase mb-4 border" style="background: rgba(212,168,83,0.15); color: #e8c878; border-color: rgba(212,168,83,0.4);">
                    Guest Agreement
                </span>
                <h1 class="font-playfair text-4xl sm:text-5xl font-bold text-white mb-4">Terms of Service & Stay</h1>
                <p class="text-sm sm:text-base text-white/70 max-w-xl mx-auto leading-relaxed">
                    General terms, booking guidelines, guest policies, and house rules at Grand Horizon Hotel & Suites.
                </p>
                <div class="mt-6 text-xs text-white/50">
                    Last Updated: August 19, 2026 &bull; Effective Immediately
                </div>
            </div>
        </header>

        {{-- ========================================== --}}
        {{-- TERMS CONTENT --}}
        {{-- ========================================== --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="rounded-3xl p-8 sm:p-12 shadow-xl border space-y-10 transition-colors duration-300" style="background-color: var(--hotel-card); border-color: var(--hotel-border);">

                {{-- Section 1 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">1</span>
                        Booking Agreement & Guest Age Policy
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed" style="color: var(--hotel-subtext);">
                        By completing a room reservation, checking in, or utilizing any services provided by <strong>Grand Horizon Hotel & Suites</strong> ("the Hotel"), you agree to abide by these Terms of Service. The registered primary guest must be at least <strong>18 years of age</strong> (or 21 years where required by local statute) and present a valid government-issued photographic ID (Passport, National ID, or Driver's License) along with a matching credit or debit card upon check-in.
                    </p>
                </div>

                {{-- Section 2 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">2</span>
                        Reservations, Guarantee & Payment Pre-Authorization
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed mb-3" style="color: var(--hotel-subtext);">
                        All reservations require a valid credit/debit card guarantee at the time of booking. Upon check-in, the Hotel will pre-authorize your credit card for the full room rate and taxes, plus a standard security deposit of <strong>$100.00 per night</strong> for incidental charges (mini-bar, room service, spa treatments). Any unused incidental hold is released immediately upon checkout.
                    </p>
                    <div class="p-4 rounded-2xl border text-xs sm:text-sm" style="background: rgba(212,168,83,0.06); border-color: rgba(212,168,83,0.2);">
                        <strong class="text-amber-500">Accepted Payment Methods:</strong> Visa, MasterCard, American Express, Discover, Bank Wire, and Cash (upon check-in with pre-authorized card deposit).
                    </div>
                </div>

                {{-- Section 3 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">3</span>
                        Check-In, Check-Out & Luggage Storage
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm mb-4">
                        <div class="p-4 rounded-2xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <div class="flex items-center gap-2 mb-1.5 font-bold" style="color: var(--hotel-heading);">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                Standard Check-In: 2:00 PM
                            </div>
                            <p style="color: var(--hotel-subtext);">Early check-in is subject to room availability upon arrival. To guarantee early morning check-in, guests must reserve the room for the preceding night.</p>
                        </div>
                        <div class="p-4 rounded-2xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <div class="flex items-center gap-2 mb-1.5 font-bold" style="color: var(--hotel-heading);">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Standard Check-Out: 11:00 AM
                            </div>
                            <p style="color: var(--hotel-subtext);">Late check-out up to 2:00 PM may be requested (subject to availability). Departures after 3:00 PM will incur a 50% daily room charge; departures after 6:00 PM incur a full night rate.</p>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm" style="color: var(--hotel-subtext);">
                        Complimentary secured luggage storage is available at the Concierge Desk for early arrivals and late departures.
                    </p>
                </div>

                {{-- Section 4 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">4</span>
                        Cancellation, Modifications & No-Show Policy
                    </h2>
                    <ul class="space-y-2 text-sm sm:text-base list-disc list-inside" style="color: var(--hotel-subtext);">
                        <li><strong>Standard Flexible Rates:</strong> Free cancellation or modification up to <strong>48 hours prior to 2:00 PM</strong> of the scheduled arrival date.</li>
                        <li><strong>Late Cancellations:</strong> Cancellations made within 48 hours of check-in will be charged the equivalent of the first night's room rate plus tax.</li>
                        <li><strong>No-Shows:</strong> Failure to arrive without notice results in forfeiture of the first night's deposit and automatic cancellation of subsequent nights.</li>
                        <li><strong>Non-Refundable Promotional Bookings:</strong> Advance purchase or special seasonal packages are strictly non-refundable and non-changeable.</li>
                    </ul>
                </div>

                {{-- Section 5 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">5</span>
                        100% Smoke-Free Property & Damage Fees
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed mb-3" style="color: var(--hotel-subtext);">
                        Grand Horizon is a strictly <strong>100% smoke-free property</strong>. Smoking of cigarettes, cigars, electronic vaporizers (e-cigarettes), shisha, or any substance is prohibited inside all guest rooms, balconies, hallways, and indoor public venues.
                    </p>
                    <div class="p-4 rounded-2xl border text-xs sm:text-sm" style="background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.25);">
                        <strong class="text-red-500">Violation Cleaning Fee:</strong> A mandatory deep-cleaning sanitation fee of <strong>$500.00</strong> will be automatically charged to the guest's folio for smoking violations. Guests will also be held financially liable for any physical damage to furniture, fixtures, audio-visual gear, or linens.
                    </div>
                </div>

                {{-- Section 6 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">6</span>
                        Quiet Hours, Conduct & House Rules
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed" style="color: var(--hotel-subtext);">
                        To ensure serene relaxation for all guests, quiet hours are observed from <strong>10:00 PM to 7:00 AM daily</strong>. Excessive noise, unauthorized parties, commercial photography without hotel management approval, or disruptive behavior may result in immediate eviction without refund. Unregistered overnight guests are not permitted.
                    </p>
                </div>

                {{-- Section 7 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">7</span>
                        Valet, Parking & Personal Valuables
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed" style="color: var(--hotel-subtext);">
                        All guest suites are equipped with digital electronic in-room safes. In accordance with standard statutory innkeeper liability laws, the Hotel is not liable for loss or damage to cash, jewelry, luxury watches, electronics, or personal valuables not deposited in the front desk main safety deposit vault. Vehicles parked in valet or guest underground parking are parked at the vehicle owner's sole risk.
                    </p>
                </div>

                {{-- Section 8 --}}
                <div class="pt-6 border-t" style="border-color: var(--hotel-border);">
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">8</span>
                        Concierge & Guest Support
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed mb-4" style="color: var(--hotel-subtext);">
                        If you have questions regarding these terms, your upcoming reservation, or specific accommodation requirements, please contact our Guest Relations team:
                    </p>
                    <div class="p-5 rounded-2xl border text-sm space-y-1.5" style="background: rgba(212,168,83,0.06); border-color: rgba(212,168,83,0.25);">
                        <p><strong>Grand Horizon Hotel & Suites — Guest Relations</strong></p>
                        <p class="text-xs" style="color: var(--hotel-subtext);">Front Desk: Available 24 Hours / 7 Days a Week</p>
                        <p class="text-xs" style="color: var(--hotel-subtext);">Email: <a href="mailto:support@grandhorizon.com" class="text-amber-500 hover:underline">support@grandhorizon.com</a></p>
                        <p class="text-xs" style="color: var(--hotel-subtext);">Reservations: +1 (555) 123-4567</p>
                    </div>
                </div>

            </div>
        </main>

        {{-- ========================================== --}}
        {{-- FOOTER --}}
        {{-- ========================================== --}}
        <footer class="py-8 px-4 sm:px-6 lg:px-8 border-t transition-colors duration-300" style="background: var(--hotel-navy); border-color: rgba(212,168,83,0.15);">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/50">
                <p>&copy; {{ date('Y') }} Grand Horizon Hotel & Suites. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="{{ route('privacy') }}" class="hover:text-amber-400 transition-colors">Privacy Policy</a>
                    <a href="{{ route('home') }}#rooms" class="hover:text-amber-400 transition-colors">Accommodations</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-amber-400 transition-colors">Contact Us</a>
                </div>
            </div>
        </footer>
    </div>
@endcomponent
