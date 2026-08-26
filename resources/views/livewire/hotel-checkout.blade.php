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
    {{-- TOP NAVBAR --}}
    {{-- ========================================== --}}
    <nav class="sticky top-0 z-50 border-b shadow-md transition-colors duration-300" style="background: rgba(15, 23, 42, 0.96); backdrop-filter: blur(20px); border-color: rgba(212,168,83,0.2);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #d4a853, #e8c878);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-white font-playfair text-base font-semibold tracking-wide">{{ config('app.name') }}</span>
                        <span class="hidden sm:inline-block text-[10px] uppercase tracking-[0.2em] ml-2" style="color: #d4a853;">Checkout</span>
                    </div>
                </a>

                {{-- Action Links --}}
                <div class="flex items-center gap-4">
                    {{-- Dark Mode Toggle --}}
                    <button @click="toggleDarkMode()" class="p-2 rounded-full border text-white/80 hover:text-white transition-all duration-300" style="border-color: rgba(212,168,83,0.3); background: rgba(255,255,255,0.05);" title="Toggle Dark/Light Mode" aria-label="Toggle theme">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    {{-- User Auth / Dropdown Menu --}}
                    <x-hotel-auth-menu />

                    <a href="{{ route('room.details', $roomCategory) }}" class="flex items-center gap-1.5 text-xs sm:text-sm text-white/70 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ========================================== --}}
    {{-- CHECKOUT CONTENT --}}
    {{-- ========================================== --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">

        @if($bookingCompleted)
            {{-- ========================================== --}}
            {{-- BOOKING SUCCESS STATE --}}
            {{-- ========================================== --}}
            <div class="max-w-3xl mx-auto rounded-3xl p-8 sm:p-12 shadow-2xl border transition-all duration-500 animate-fade-in-up" style="background-color: var(--hotel-card); border-color: var(--hotel-border);">
                {{-- Success Header --}}
                <div class="text-center mb-10">
                    <div class="w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #16a34a, #15803d);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </div>
                    <p class="text-xs uppercase tracking-[0.3em] font-semibold" style="color: #d4a853;">Reservation Confirmed</p>
                    <h1 class="font-playfair text-3xl sm:text-4xl font-bold mt-2" style="color: var(--hotel-heading);">Thank You, {{ $name }}!</h1>
                    <p class="text-sm mt-3 max-w-md mx-auto" style="color: var(--hotel-subtext);">
                        Your booking has been received and confirmed. A confirmation copy has been sent to <span class="font-semibold text-amber-500">{{ $email }}</span>.
                    </p>
                </div>

                {{-- Reference & Overview Card --}}
                <div class="rounded-2xl p-6 mb-8 border" style="background: rgba(212,168,83,0.06); border-color: rgba(212,168,83,0.25);">
                    <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-amber-500/20">
                        <div>
                            <span class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Booking Reference</span>
                            <p class="font-mono text-xl font-bold tracking-wider" style="color: #d4a853;">{{ $bookingReference }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Paid / Due</span>
                            <p class="text-xl font-bold font-playfair" style="color: var(--hotel-heading);">₦{{ number_format($totalPrice, 2) }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 text-sm">
                        <div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 block">Room Category</span>
                            <span class="font-semibold" style="color: var(--hotel-heading);">{{ $roomCategory->name }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 block">Check-In Date</span>
                            <span class="font-semibold" style="color: var(--hotel-heading);">{{ \Carbon\Carbon::parse($checkIn)->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 block">Check-Out Date</span>
                            <span class="font-semibold" style="color: var(--hotel-heading);">{{ \Carbon\Carbon::parse($checkOut)->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Key Information List --}}
                <div class="space-y-3 mb-10 text-sm" style="color: var(--hotel-subtext);">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span><strong>Standard Check-in:</strong> 2:00 PM | <strong>Check-out:</strong> 11:00 AM</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Complimentary high-speed WiFi, access to rooftop infinity pool, and 24/7 fitness center included.</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="px-8 py-3.5 rounded-xl font-semibold text-sm text-white text-center transition-all duration-300 hover:scale-105 shadow-lg" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                        Return to Homepage
                    </a>
                    <button onclick="window.print()" class="px-8 py-3.5 rounded-xl font-semibold text-sm border text-center transition-all duration-300 hover:bg-black/5 dark:hover:bg-white/5" style="border-color: var(--hotel-border); color: var(--hotel-heading);">
                        Print Receipt
                    </button>
                </div>
            </div>

        @else

            {{-- ========================================== --}}
            {{-- CHECKOUT FORM & SUMMARY --}}
            {{-- ========================================== --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

                {{-- LEFT COLUMN: Guest Form (7 cols) --}}
                <div class="lg:col-span-7 space-y-8">

                    {{-- Page Title --}}
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] font-semibold mb-2" style="color: #d4a853;">Reservation Details</p>
                        <h1 class="font-playfair text-3xl sm:text-4xl font-bold" style="color: var(--hotel-heading);">Guest Information</h1>
                        <p class="text-sm mt-2" style="color: var(--hotel-subtext);">Please provide your contact details to secure your reservation at {{ config('app.name') }}.</p>
                    </div>

                    @if (session()->has('error'))
                        <div class="p-4 rounded-xl border flex items-start gap-3 bg-red-500/10 border-red-500/30 text-red-600 dark:text-red-400 text-sm">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <form wire:submit="processBooking" class="space-y-6">

                        {{-- 1. Guest Personal Info Card --}}
                        <div class="rounded-2xl p-6 sm:p-8 shadow-lg border transition-colors duration-300" style="background-color: var(--hotel-card); border-color: var(--hotel-border);">
                            <h2 class="font-playfair text-xl font-semibold mb-6 flex items-center gap-3" style="color: var(--hotel-heading);">
                                <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: #d4a853;">1</span>
                                Contact Details
                            </h2>

                            <div class="space-y-4">
                                {{-- Full Name --}}
                                <div>
                                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--hotel-heading);">Full Name *</label>
                                    <input type="text" id="name" wire:model.blur="name" placeholder="e.g. Johnathan Doe" class="w-full rounded-xl px-4 py-3 text-sm border focus:outline-none focus:ring-2 transition-all" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border); color: var(--hotel-heading); --tw-ring-color: #d4a853;">
                                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Email & Phone --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--hotel-heading);">Email Address *</label>
                                        <input type="email" id="email" wire:model.blur="email" placeholder="john@example.com" class="w-full rounded-xl px-4 py-3 text-sm border focus:outline-none focus:ring-2 transition-all" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border); color: var(--hotel-heading); --tw-ring-color: #d4a853;">
                                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--hotel-heading);">Phone Number *</label>
                                        <input type="tel" id="phone" wire:model.blur="phone" placeholder="+1 (555) 000-0000" class="w-full rounded-xl px-4 py-3 text-sm border focus:outline-none focus:ring-2 transition-all" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border); color: var(--hotel-heading); --tw-ring-color: #d4a853;">
                                        @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Stay Details & Dates Card --}}
                        <div class="rounded-2xl p-6 sm:p-8 shadow-lg border transition-colors duration-300" style="background-color: var(--hotel-card); border-color: var(--hotel-border);">
                            <h2 class="font-playfair text-xl font-semibold mb-6 flex items-center gap-3" style="color: var(--hotel-heading);">
                                <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: #d4a853;">2</span>
                                Stay Dates & Guests
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label for="checkIn" class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--hotel-heading);">Check-In</label>
                                    <input type="date" id="checkIn" wire:model.live="checkIn" min="{{ now()->format('Y-m-d') }}" class="w-full rounded-xl px-4 py-3 text-sm border focus:outline-none focus:ring-2 transition-all" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border); color: var(--hotel-heading); --tw-ring-color: #d4a853;">
                                    @error('checkIn') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="checkOut" class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--hotel-heading);">Check-Out</label>
                                    <input type="date" id="checkOut" wire:model.live="checkOut" min="{{ now()->addDay()->format('Y-m-d') }}" class="w-full rounded-xl px-4 py-3 text-sm border focus:outline-none focus:ring-2 transition-all" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border); color: var(--hotel-heading); --tw-ring-color: #d4a853;">
                                    @error('checkOut') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="guests" class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--hotel-heading);">Number of Guests</label>
                                    <select id="guests" wire:model.live="guests" class="w-full rounded-xl px-4 py-3 text-sm border focus:outline-none focus:ring-2 transition-all" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border); color: var(--hotel-heading); --tw-ring-color: #d4a853;">
                                        @for($i = 1; $i <= max(1, $roomCategory->capacity); $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}</option>
                                        @endfor
                                    </select>
                                    @error('guests') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-xs">
                                <span class="text-gray-500">Maximum Category Capacity:</span>
                                <span class="font-semibold" style="color: #d4a853;">{{ $roomCategory->capacity }} Guests</span>
                            </div>
                        </div>

                        {{-- 3. Preferences & Payment Card --}}
                        <div class="rounded-2xl p-6 sm:p-8 shadow-lg border transition-colors duration-300" style="background-color: var(--hotel-card); border-color: var(--hotel-border);">
                            <h2 class="font-playfair text-xl font-semibold mb-6 flex items-center gap-3" style="color: var(--hotel-heading);">
                                <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: #d4a853;">3</span>
                                Preferences & Payment Option
                            </h2>

                            <div class="space-y-4">
                                {{-- Arrival Time --}}
                                <div>
                                    <label for="estimatedArrival" class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--hotel-heading);">Estimated Arrival Time</label>
                                    <select id="estimatedArrival" wire:model="estimatedArrival" class="w-full rounded-xl px-4 py-3 text-sm border focus:outline-none focus:ring-2 transition-all" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border); color: var(--hotel-heading); --tw-ring-color: #d4a853;">
                                        <option value="12:00 - 14:00">12:00 PM - 2:00 PM (Early Check-In upon availability)</option>
                                        <option value="14:00 - 16:00" selected>2:00 PM - 4:00 PM (Standard)</option>
                                        <option value="16:00 - 18:00">4:00 PM - 6:00 PM</option>
                                        <option value="18:00 - 20:00">6:00 PM - 8:00 PM</option>
                                        <option value="After 20:00">After 8:00 PM (Late Arrival)</option>
                                    </select>
                                </div>

                                {{-- Special Requests --}}
                                <div>
                                    <label for="specialRequests" class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--hotel-heading);">Special Requests (Optional)</label>
                                    <textarea id="specialRequests" wire:model="specialRequests" rows="3" placeholder="High floor, extra pillows, quiet room, dietary requests..." class="w-full rounded-xl px-4 py-3 text-sm border focus:outline-none focus:ring-2 transition-all" style="background: var(--hotel-card-subtle); border-color: var(--hotel-border); color: var(--hotel-heading); --tw-ring-color: #d4a853;"></textarea>
                                </div>

                                {{-- Payment Method Radio Group --}}
                                <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                                    <label class="block text-xs font-semibold uppercase tracking-wider mb-3" style="color: var(--hotel-heading);">Select Payment Method</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        {{-- Credit/Debit Card --}}
                                        <label class="relative flex flex-col p-4 rounded-xl border cursor-pointer transition-all duration-300 hover:border-amber-500" :class="$wire.paymentMethod === 'card' ? 'border-amber-500 bg-amber-500/5 ring-1 ring-amber-500' : 'border-gray-200 dark:border-gray-800'">
                                            <input type="radio" wire:model="paymentMethod" value="card" class="sr-only">
                                            <div class="flex items-center justify-between mb-2">
                                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="$wire.paymentMethod === 'card' ? 'border-amber-500 bg-amber-500' : 'border-gray-300 dark:border-gray-600'">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="$wire.paymentMethod === 'card'"></div>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold" style="color: var(--hotel-heading);">Credit Card</span>
                                            <span class="text-[10px] text-gray-500">Secure Instant Pay</span>
                                        </label>

                                        {{-- Pay at Hotel --}}
                                        <label class="relative flex flex-col p-4 rounded-xl border cursor-pointer transition-all duration-300 hover:border-amber-500" :class="$wire.paymentMethod === 'arrival' ? 'border-amber-500 bg-amber-500/5 ring-1 ring-amber-500' : 'border-gray-200 dark:border-gray-800'">
                                            <input type="radio" wire:model="paymentMethod" value="arrival" class="sr-only">
                                            <div class="flex items-center justify-between mb-2">
                                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/></svg>
                                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="$wire.paymentMethod === 'arrival' ? 'border-amber-500 bg-amber-500' : 'border-gray-300 dark:border-gray-600'">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="$wire.paymentMethod === 'arrival'"></div>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold" style="color: var(--hotel-heading);">Pay on Arrival</span>
                                            <span class="text-[10px] text-gray-500">Cash or POS at Desk</span>
                                        </label>

                                        {{-- Bank Transfer --}}
                                        <label class="relative flex flex-col p-4 rounded-xl border cursor-pointer transition-all duration-300 hover:border-amber-500" :class="$wire.paymentMethod === 'bank_transfer' ? 'border-amber-500 bg-amber-500/5 ring-1 ring-amber-500' : 'border-gray-200 dark:border-gray-800'">
                                            <input type="radio" wire:model="paymentMethod" value="bank_transfer" class="sr-only">
                                            <div class="flex items-center justify-between mb-2">
                                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="$wire.paymentMethod === 'bank_transfer' ? 'border-amber-500 bg-amber-500' : 'border-gray-300 dark:border-gray-600'">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="$wire.paymentMethod === 'bank_transfer'"></div>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold" style="color: var(--hotel-heading);">Bank Transfer</span>
                                            <span class="text-[10px] text-gray-500">Direct Wire Transfer</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button type="submit" wire:loading.attr="disabled" class="w-full py-4 rounded-2xl font-semibold text-base text-white tracking-wide uppercase shadow-xl transition-all duration-300 hover:scale-[1.01] hover:shadow-[0_0_30px_rgba(212,168,83,0.4)] flex items-center justify-center gap-3 disabled:opacity-50" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                                <svg wire:loading class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                <span wire:loading.remove>Confirm Reservation &bull; ₦{{ number_format($totalPrice, 2) }}</span>
                                <span wire:loading>Processing Reservation...</span>
                            </button>
                            <p class="text-center text-xs mt-3 text-gray-400">By confirming, you agree to the {{ config('app.name') }} Booking & Cancellation Policy.</p>
                        </div>
                    </form>
                </div>

                {{-- RIGHT COLUMN: Sticky Summary (5 cols) --}}
                <div class="lg:col-span-5 lg:sticky lg:top-24">
                    <div class="rounded-3xl overflow-hidden shadow-2xl border transition-colors duration-300" style="background-color: var(--hotel-card); border-color: var(--hotel-border);">

                        {{-- Image Header --}}
                        <div class="relative h-48 sm:h-56 overflow-hidden">
                            @if($roomCategory->images && count($roomCategory->images) > 0)
                                <img src="{{ asset('storage/' . $roomCategory->images[0]) }}" alt="{{ $roomCategory->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/hotel/room.jpg') }}" alt="{{ $roomCategory->name }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <span class="text-[10px] tracking-[0.2em] uppercase font-semibold text-amber-400">Selected Category</span>
                                <h3 class="font-playfair text-xl font-bold">{{ $roomCategory->name }}</h3>
                            </div>
                        </div>

                        {{-- Summary Breakdown --}}
                        <div class="p-6 sm:p-8 space-y-6">

                            {{-- Stay Overview --}}
                            <div class="grid grid-cols-2 gap-4 p-4 rounded-xl text-xs" style="background: var(--hotel-card-subtle); border: 1px solid var(--hotel-border);">
                                <div>
                                    <span class="text-gray-500 block mb-0.5">Check-In</span>
                                    <span class="font-bold" style="color: var(--hotel-heading);">{{ \Carbon\Carbon::parse($checkIn)->format('D, M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 block mb-0.5">Check-Out</span>
                                    <span class="font-bold" style="color: var(--hotel-heading);">{{ \Carbon\Carbon::parse($checkOut)->format('D, M d, Y') }}</span>
                                </div>
                            </div>

                            {{-- Availability Badge --}}
                            <div class="flex items-center justify-between text-xs py-2 px-3 rounded-lg" style="{{ $isAvailable ? 'background: rgba(34,197,94,0.1); color: #16a34a;' : 'background: rgba(239,68,68,0.1); color: #ef4444;' }}">
                                <span class="flex items-center gap-1.5 font-semibold">
                                    <span class="w-2 h-2 rounded-full" style="{{ $isAvailable ? 'background: #16a34a;' : 'background: #ef4444;' }}"></span>
                                    {{ $isAvailable ? 'Room Available for Selected Dates' : 'No Open Rooms for These Dates' }}
                                </span>
                                <span>{{ $totalNights }} Night{{ $totalNights > 1 ? 's' : '' }}</span>
                            </div>

                            {{-- Price Computation --}}
                            <div class="space-y-3 text-sm pt-2">
                                <div class="flex justify-between" style="color: var(--hotel-subtext);">
                                    <span>₦{{ number_format($roomCategory->amount, 2) }} &times; {{ $totalNights }} {{ $totalNights === 1 ? 'night' : 'nights' }}</span>
                                    <span class="font-medium" style="color: var(--hotel-heading);">₦{{ number_format($basePrice, 2) }}</span>
                                </div>
                                <div class="flex justify-between" style="color: var(--hotel-subtext);">
                                    <span>Service & Hospitality Fee (5%)</span>
                                    <span class="font-medium" style="color: var(--hotel-heading);">₦{{ number_format($serviceFee, 2) }}</span>
                                </div>
                                <div class="flex justify-between" style="color: var(--hotel-subtext);">
                                    <span>State & Occupancy Tax (7.5%)</span>
                                    <span class="font-medium" style="color: var(--hotel-heading);">₦{{ number_format($taxAmount, 2) }}</span>
                                </div>

                                <div class="pt-4 border-t border-gray-200 dark:border-gray-800 flex justify-between items-center">
                                    <div>
                                        <span class="text-base font-bold" style="color: var(--hotel-heading);">Total Due</span>
                                        <span class="text-[11px] block text-gray-500">Includes all taxes and fees</span>
                                    </div>
                                    <span class="text-2xl font-bold font-playfair" style="color: #d4a853;">₦{{ number_format($totalPrice, 2) }}</span>
                                </div>
                            </div>

                            {{-- Security & Guarantee Badges --}}
                            <div class="p-4 rounded-xl border space-y-2 text-xs" style="background: rgba(212,168,83,0.04); border-color: rgba(212,168,83,0.15);">
                                <div class="flex items-center gap-2" style="color: var(--hotel-heading);">
                                    <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <span class="font-semibold">Best Rate Guaranteed</span>
                                </div>
                                <p class="text-[11px] text-gray-500 leading-relaxed">Free cancellation up to 48 hours before check-in date. Instant booking confirmation.</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

    {{-- Footer --}}
    <footer class="py-8 border-t mt-16 transition-colors duration-300" style="background: var(--hotel-navy); border-color: rgba(212,168,83,0.15);">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/50">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }} Hotel & Suites. All rights reserved. Secure Encrypted Checkout.</p>
            <div class="flex gap-6">
                <a href="{{ route('privacy') }}" class="hover:text-amber-400 transition-colors">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="hover:text-amber-400 transition-colors">Terms of Service</a>
            </div>
        </div>
    </footer>
</div>
