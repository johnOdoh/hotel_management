@component('layouts.guest', ['title' => 'Privacy Policy — '. config('app.name') .' Hotel & Suites'])
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
                            <span class="text-white font-playfair text-lg font-semibold tracking-wide block">{{ config('app.name') }}</span>
                            <span class="hidden sm:block text-[10px] tracking-[0.25em] uppercase font-medium" style="color: #d4a853;">Hotel & Suites</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-4 sm:gap-6">
                        <a href="{{ route('home') }}" class="text-xs sm:text-sm font-medium text-white/80 hover:text-white transition-colors">Home</a>

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
                    Legal & Privacy
                </span>
                <h1 class="font-playfair text-4xl sm:text-5xl font-bold text-white mb-4">Guest Privacy Policy</h1>
                <p class="text-sm sm:text-base text-white/70 max-w-xl mx-auto leading-relaxed">
                    How {{ config('app.name') }} Hotel & Suites collects, safeguards, and respects your personal information.
                </p>
                <div class="mt-6 text-xs text-white/50">
                    Last Updated: August 19, 2026 &bull; Effective Immediately
                </div>
            </div>
        </header>

        {{-- ========================================== --}}
        {{-- POLICY CONTENT --}}
        {{-- ========================================== --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="rounded-3xl p-8 sm:p-12 shadow-xl border space-y-10 transition-colors duration-300" style="background-color: var(--hotel-card); border-color: var(--hotel-border);">

                {{-- Section 1 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">1</span>
                        Our Commitment to Hospitality Privacy
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed" style="color: var(--hotel-subtext);">
                        At <strong>{{ config('app.name') }} Hotel & Suites</strong> ("we," "our," or "the Hotel"), your trust is our most valued asset. We are dedicated to maintaining the confidentiality, integrity, and security of all personal information entrusted to us by our guests, visitors, patrons, and website users. This Privacy Policy details the types of information we collect, how it is utilized to elevate your stay, and your legal rights regarding your data.
                    </p>
                </div>

                {{-- Section 2 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">2</span>
                        Information We Collect
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed mb-4" style="color: var(--hotel-subtext);">
                        To provide personalized hospitality, fulfill room reservations, and comply with international hotel regulations, we collect the following categories of information:
                    </p>
                    <ul class="space-y-2.5 text-sm sm:text-base list-disc list-inside" style="color: var(--hotel-subtext);">
                        <li><strong>Contact & Identification Details:</strong> Full name, passport or government-issued ID details, nationality, date of birth, residential address, telephone number, and email address.</li>
                        <li><strong>Reservation & Stay Information:</strong> Check-in and check-out dates, room category choices, number of accompanying guests, special assistance or accessibility needs, flight numbers, and estimated arrival times.</li>
                        <li><strong>Billing & Payment Data:</strong> Credit/debit card numbers, expiration dates, billing addresses, and transactional history processed through encrypted Level 1 PCI-DSS certified gateways.</li>
                        <li><strong>Guest Preferences & Personalization:</strong> Dietary preferences, pillow preferences, anniversary/birthday celebrations, dining history, spa treatments, and recreational requests.</li>
                        <li><strong>On-Premises Technical Data:</strong> Public guest Wi-Fi connection logs, electronic keycard access timestamps, and closed-circuit television (CCTV) security footage in public hotel areas.</li>
                    </ul>
                </div>

                {{-- Section 3 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">3</span>
                        How We Use Your Information
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed mb-3" style="color: var(--hotel-subtext);">
                        We process your personal information strictly for legitimate business and hospitality purposes:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                        <div class="p-4 rounded-2xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <h4 class="font-bold mb-1" style="color: var(--hotel-heading);">Reservation Fulfillment</h4>
                            <p style="color: var(--hotel-subtext);">To process bookings, issue confirmation vouchers, prepare guest suites, and handle seamless check-in and checkout.</p>
                        </div>
                        <div class="p-4 rounded-2xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <h4 class="font-bold mb-1" style="color: var(--hotel-heading);">Personalized Guest Service</h4>
                            <p style="color: var(--hotel-subtext);">To accommodate dietary needs, customize room amenities, and provide tailored concierge recommendations.</p>
                        </div>
                        <div class="p-4 rounded-2xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <h4 class="font-bold mb-1" style="color: var(--hotel-heading);">Safety & Security</h4>
                            <p style="color: var(--hotel-subtext);">To protect the well-being of guests, maintain premises security via CCTV, and manage keycard authorization.</p>
                        </div>
                        <div class="p-4 rounded-2xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <h4 class="font-bold mb-1" style="color: var(--hotel-heading);">Legal Compliance</h4>
                            <p style="color: var(--hotel-subtext);">To satisfy mandatory municipal tourist tax records, immigration reporting, and hotel guest register statutes.</p>
                        </div>
                    </div>
                </div>

                {{-- Section 4 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">4</span>
                        CCTV & Premises Surveillance
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed" style="color: var(--hotel-subtext);">
                        For the physical safety of our guests, team members, and premises, closed-circuit television (CCTV) cameras operate 24 hours a day in common areas, including entrances, lobby lounges, corridors, elevator lobbies, parking structures, and exterior grounds. <strong>No surveillance equipment is ever placed inside guest rooms, private suites, restrooms, or spa changing areas.</strong> CCTV footage is retained for a maximum of 30 days unless required by law enforcement for active incident investigations.
                    </p>
                </div>

                {{-- Section 5 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">5</span>
                        Third-Party Disclosures & Data Sharing
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed mb-3" style="color: var(--hotel-subtext);">
                        <strong>We never sell, rent, or trade your personal data to external advertisers.</strong> Information is shared solely with trusted service providers assisting hotel operations under strict non-disclosure obligations:
                    </p>
                    <ul class="space-y-2 text-sm sm:text-base list-disc list-inside" style="color: var(--hotel-subtext);">
                        <li>Certified payment processing platforms and merchant banking partners.</li>
                        <li>Direct hotel reservation technology providers and channel managers.</li>
                        <li>Authorized law enforcement or regulatory authorities when formally mandated by court order or local statute.</li>
                    </ul>
                </div>

                {{-- Section 6 --}}
                <div>
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">6</span>
                        Your Privacy Rights
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed mb-4" style="color: var(--hotel-subtext);">
                        Depending on your country of residence (including GDPR, CCPA, and international privacy frameworks), you have the right to:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs sm:text-sm">
                        <div class="p-3.5 rounded-xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <span class="font-bold block mb-1" style="color: #d4a853;">Access & Rectification</span>
                            <span style="color: var(--hotel-subtext);">Request copies of your stored records and rectify inaccuracies.</span>
                        </div>
                        <div class="p-3.5 rounded-xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <span class="font-bold block mb-1" style="color: #d4a853;">Right to Erasure</span>
                            <span style="color: var(--hotel-subtext);">Request deletion of marketing preferences and non-mandatory records.</span>
                        </div>
                        <div class="p-3.5 rounded-xl border" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border);">
                            <span class="font-bold block mb-1" style="color: #d4a853;">Opt-Out of Marketing</span>
                            <span style="color: var(--hotel-subtext);">Unsubscribe from newsletters and seasonal promotional invitations anytime.</span>
                        </div>
                    </div>
                </div>

                {{-- Section 7 --}}
                <div class="pt-6 border-t" style="border-color: var(--hotel-border);">
                    <h2 class="font-playfair text-2xl font-bold mb-3 flex items-center gap-3" style="color: var(--hotel-heading);">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0" style="background: #d4a853;">7</span>
                        Contact Data Protection Officer (DPO)
                    </h2>
                    <p class="text-sm sm:text-base leading-relaxed mb-4" style="color: var(--hotel-subtext);">
                        For inquiries, data access requests, or privacy concerns, please contact our dedicated Data Protection Officer:
                    </p>
                    <div class="p-5 rounded-2xl border text-sm space-y-1.5" style="background: rgba(212,168,83,0.06); border-color: rgba(212,168,83,0.25);">
                        <p><strong>{{ config('app.name') }} Hotel & Suites — Privacy Office</strong></p>
                        <p class="text-xs" style="color: var(--hotel-subtext);">Address: {{ config('app.address') }}</p>
                        <p class="text-xs" style="color: var(--hotel-subtext);">Email: <a href="mailto:{{ config('app.email') }}" class="text-amber-500 hover:underline">{{ config('app.email') }}</a></p>
                        <p class="text-xs" style="color: var(--hotel-subtext);">Phone: <a href="tel:{{ config('app.phone1') }}" class="text-amber-500 hover:underline">{{ config('app.phone1') }}</a> (Ext: Privacy & Compliance)</p>
                    </div>
                </div>

            </div>
        </main>

        {{-- ========================================== --}}
        {{-- FOOTER --}}
        {{-- ========================================== --}}
        <footer class="py-8 px-4 sm:px-6 lg:px-8 border-t transition-colors duration-300" style="background: var(--hotel-navy); border-color: rgba(212,168,83,0.15);">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/50">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }} Hotel & Suites. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="{{ route('terms') }}" class="hover:text-amber-400 transition-colors">Terms of Service</a>
                    <a href="{{ route('home') }}#rooms" class="hover:text-amber-400 transition-colors">Accommodations</a>
                    <a href="{{ route('home') }}#contact" class="hover:text-amber-400 transition-colors">Contact Us</a>
                </div>
            </div>
        </footer>
    </div>
@endcomponent
