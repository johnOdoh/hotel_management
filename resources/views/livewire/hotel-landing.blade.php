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
    },
    galleryFilter: 'all',
    lightboxOpen: false,
    lightboxImage: '',
    lightboxTitle: '',
    lightboxDesc: '',
    openLightbox(img, title, desc) {
        this.lightboxImage = img;
        this.lightboxTitle = title;
        this.lightboxDesc = desc;
        this.lightboxOpen = true;
    }
}" class="min-h-screen transition-colors duration-300" style="background-color: var(--hotel-bg); color: var(--hotel-text);">

    {{-- ========================================== --}}
    {{-- NAVIGATION BAR --}}
    {{-- ========================================== --}}
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-500" x-data="{ scrolled: false, mobileOpen: false }"
         x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
         :class="scrolled ? 'shadow-2xl' : ''" 
         :style="scrolled ? 'background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(20px);' : 'background: linear-gradient(to bottom, rgba(15,23,42,0.8) 0%, rgba(15,23,42,0) 100%);'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
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

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-7">
                    <a href="#rooms" class="text-white/80 hover:text-white text-sm font-medium tracking-wide transition-colors duration-300 hover:drop-shadow-[0_0_8px_rgba(212,168,83,0.4)]">Rooms</a>
                    <a href="#gallery" class="text-white/80 hover:text-white text-sm font-medium tracking-wide transition-colors duration-300 hover:drop-shadow-[0_0_8px_rgba(212,168,83,0.4)]">Gallery</a>
                    <a href="#amenities" class="text-white/80 hover:text-white text-sm font-medium tracking-wide transition-colors duration-300 hover:drop-shadow-[0_0_8px_rgba(212,168,83,0.4)]">Amenities</a>
                    <a href="#about" class="text-white/80 hover:text-white text-sm font-medium tracking-wide transition-colors duration-300 hover:drop-shadow-[0_0_8px_rgba(212,168,83,0.4)]">About</a>
                    <a href="#contact" class="text-white/80 hover:text-white text-sm font-medium tracking-wide transition-colors duration-300 hover:drop-shadow-[0_0_8px_rgba(212,168,83,0.4)]">Contact</a>

                    {{-- Dark Mode Toggle Button --}}
                    <button @click="toggleDarkMode()" class="p-2 rounded-full border text-white/80 hover:text-white transition-all duration-300 hover:scale-105" style="border-color: rgba(212,168,83,0.35); background: rgba(255,255,255,0.08);" title="Toggle Dark/Light Mode" aria-label="Toggle theme">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    <a href="#availability" class="px-6 py-2.5 rounded-full text-sm font-semibold text-white tracking-wide uppercase transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-[0_0_20px_rgba(212,168,83,0.4)]" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                        Book Now
                    </a>
                </div>

                {{-- Mobile Menu Toggle & Theme --}}
                <div class="flex items-center gap-2 md:hidden">
                    <button @click="toggleDarkMode()" class="p-2 rounded-full border text-white/80" style="border-color: rgba(212,168,83,0.3); background: rgba(255,255,255,0.08);" aria-label="Toggle theme">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    <button @click="mobileOpen = !mobileOpen" class="text-white p-2" aria-label="Open mobile menu">
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Nav --}}
            <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="md:hidden pb-6 border-t border-white/10" style="background: rgba(15, 23, 42, 0.98);">
                <div class="flex flex-col gap-4 pt-4 px-2">
                    <a href="#rooms" @click="mobileOpen = false" class="text-white/80 hover:text-white text-sm font-medium py-1.5">Rooms</a>
                    <a href="#gallery" @click="mobileOpen = false" class="text-white/80 hover:text-white text-sm font-medium py-1.5">Gallery</a>
                    <a href="#amenities" @click="mobileOpen = false" class="text-white/80 hover:text-white text-sm font-medium py-1.5">Amenities</a>
                    <a href="#about" @click="mobileOpen = false" class="text-white/80 hover:text-white text-sm font-medium py-1.5">About</a>
                    <a href="#contact" @click="mobileOpen = false" class="text-white/80 hover:text-white text-sm font-medium py-1.5">Contact</a>
                    <a href="#availability" @click="mobileOpen = false" class="px-6 py-2.5 rounded-full text-sm font-semibold text-white text-center" style="background: linear-gradient(135deg, #d4a853, #b8922f);">Book Now</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ========================================== --}}
    {{-- HERO SECTION WITH DAY & NIGHT CAROUSEL --}}
    {{-- ========================================== --}}
    <section class="relative min-h-[90vh] sm:min-h-screen flex items-center justify-center overflow-hidden" 
             x-data="{
                 activeHero: 0,
                 heroSlides: [
                     { image: '{{ asset('images/hotel/hero_night.jpg') }}', title: 'Night Twilight View', tag: '✨ Twilight Serenity' },
                     { image: '{{ asset('images/hotel/hero_day.jpg') }}', title: 'Sunlit Coastal View', tag: '☀️ Sunlit Grandeur' }
                 ],
                 heroTimer: null,
                 startHeroAutoPlay() {
                     this.heroTimer = setInterval(() => {
                         this.activeHero = (this.activeHero + 1) % this.heroSlides.length;
                     }, 6000);
                 },
                 stopHeroAutoPlay() {
                     clearInterval(this.heroTimer);
                 },
                 setHero(idx) {
                     this.activeHero = idx;
                     this.stopHeroAutoPlay();
                     this.startHeroAutoPlay();
                 }
             }"
             x-init="startHeroAutoPlay()"
             @mouseenter="stopHeroAutoPlay()"
             @mouseleave="startHeroAutoPlay()">

        {{-- Background Image Slides --}}
        <template x-for="(slide, index) in heroSlides" :key="index">
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                 :class="activeHero === index ? 'opacity-100 scale-100' : 'opacity-0 scale-105 pointer-events-none'">
                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">
                <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(15,23,42,0.55) 0%, rgba(15,23,42,0.3) 40%, rgba(15,23,42,0.8) 100%);"></div>
            </div>
        </template>

        {{-- Day / Night Switcher Badge --}}
        <div class="absolute top-28 right-4 sm:right-8 z-30 flex items-center gap-2 p-1.5 rounded-full border shadow-xl transition-all" style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(15px); border-color: rgba(212, 168, 83, 0.3);">
            <button @click="setHero(0)" class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-all duration-300" :class="activeHero === 0 ? 'bg-amber-500 text-white shadow-md' : 'text-white/70 hover:text-white'">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                <span>Night</span>
            </button>
            <button @click="setHero(1)" class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-all duration-300" :class="activeHero === 1 ? 'bg-amber-500 text-white shadow-md' : 'text-white/70 hover:text-white'">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/></svg>
                <span>Day</span>
            </button>
        </div>

        {{-- Hero Content --}}
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto pt-24 pb-16">
            <div class="animate-fade-in-up">
                <span class="inline-block py-1 px-4 rounded-full text-xs font-semibold tracking-[0.25em] uppercase mb-6 border shadow-sm" style="background: rgba(212,168,83,0.15); color: #e8c878; border-color: rgba(212,168,83,0.4);">
                    <span x-text="heroSlides[activeHero].tag"></span>
                </span>
            </div>

            <h1 class="font-playfair text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold text-white mb-6 animate-fade-in-up animation-delay-200" style="line-height: 1.08;">
                Grand<br>
                <span class="text-gradient-gold">Horizon</span>
            </h1>

            <p class="text-base sm:text-xl text-white/85 font-light max-w-2xl mx-auto mb-4 animate-fade-in-up animation-delay-400">
                Hotel & Suites
            </p>

            <div class="w-28 h-px mx-auto mb-6 animate-fade-in-up animation-delay-400" style="background: linear-gradient(90deg, transparent, #d4a853, transparent);"></div>

            <p class="text-sm sm:text-lg text-white/75 font-light max-w-xl mx-auto mb-10 animate-fade-in-up animation-delay-600 leading-relaxed">
                Experience unparalleled luxury, panoramic sea views, and world-class hospitality tailored to your highest desires.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-600">
                <a href="#availability" class="px-8 py-4 rounded-full text-xs sm:text-sm font-semibold text-white tracking-wider uppercase transition-all duration-300 hover:scale-105 shadow-xl hover:shadow-[0_0_30px_rgba(212,168,83,0.4)]" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                    Check Availability
                </a>
                <a href="#gallery" class="px-8 py-4 rounded-full text-xs sm:text-sm font-semibold text-white tracking-wider uppercase transition-all duration-300 hover:scale-105 border border-white/30 hover:border-white/70 hover:bg-white/10 backdrop-blur-sm">
                    View Gallery
                </a>
            </div>
        </div>

        {{-- Hero Carousel Dots Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2.5">
            <template x-for="(slide, idx) in heroSlides" :key="idx">
                <button @click="setHero(idx)" class="transition-all duration-300 rounded-full" :class="activeHero === idx ? 'w-8 h-2.5 bg-amber-400' : 'w-2.5 h-2.5 bg-white/40 hover:bg-white/80'" :aria-label="'Go to slide ' + (idx + 1)"></button>
            </template>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- AVAILABILITY CHECKER --}}
    {{-- ========================================== --}}
    <section id="availability" class="relative -mt-16 sm:-mt-20 z-20 px-4 sm:px-6 lg:px-8 mb-20">
        <div class="max-w-5xl mx-auto">
            <div class="glass-dark rounded-3xl p-6 sm:p-8 shadow-2xl border" style="border-color: rgba(212,168,83,0.25);">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="font-playfair text-2xl sm:text-3xl text-white font-bold">Check Room Availability</h2>
                        <p class="text-xs sm:text-sm text-white/60 mt-1">Direct booking guaranteed best available rates</p>
                    </div>
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-xs text-amber-400 font-semibold px-3 py-1 rounded-full bg-amber-400/10 border border-amber-400/20">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Instant Confirmation
                    </span>
                </div>

                <form wire:submit="checkAvailability" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    {{-- Room Category --}}
                    <div>
                        <label for="landing-category" class="block text-xs uppercase tracking-wider font-semibold mb-2" style="color: #d4a853;">Room Category</label>
                        <select wire:model="selectedCategory" id="landing-category" class="w-full rounded-xl px-4 py-3.5 text-sm text-white border focus:outline-none focus:ring-2 transition-all cursor-pointer" style="background: rgba(255,255,255,0.08); border-color: rgba(212,168,83,0.3); --tw-ring-color: #d4a853;">
                            <option value="" style="background: #1e293b;">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" style="background: #1e293b;">{{ $category->name }} — ${{ number_format($category->amount, 0) }}/nt</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Check-in --}}
                    <div>
                        <label for="landing-checkin" class="block text-xs uppercase tracking-wider font-semibold mb-2" style="color: #d4a853;">Check-in Date</label>
                        <input type="date" wire:model="checkIn" id="landing-checkin" min="{{ now()->format('Y-m-d') }}" class="w-full rounded-xl px-4 py-3 text-sm text-white border focus:outline-none focus:ring-2 transition-all cursor-pointer" style="background: rgba(255,255,255,0.08); border-color: rgba(212,168,83,0.3); --tw-ring-color: #d4a853; color-scheme: dark;">
                    </div>

                    {{-- Check-out --}}
                    <div>
                        <label for="landing-checkout" class="block text-xs uppercase tracking-wider font-semibold mb-2" style="color: #d4a853;">Check-out Date</label>
                        <input type="date" wire:model="checkOut" id="landing-checkout" min="{{ now()->addDay()->format('Y-m-d') }}" class="w-full rounded-xl px-4 py-3 text-sm text-white border focus:outline-none focus:ring-2 transition-all cursor-pointer" style="background: rgba(255,255,255,0.08); border-color: rgba(212,168,83,0.3); --tw-ring-color: #d4a853; color-scheme: dark;">
                    </div>

                    {{-- Submit Button --}}
                    <div>
                        <button type="submit" wire:loading.attr="disabled" class="w-full rounded-xl px-6 py-3.5 text-sm font-semibold text-white tracking-wide uppercase transition-all duration-300 hover:scale-[1.02] shadow-xl hover:shadow-[0_0_20px_rgba(212,168,83,0.3)] flex items-center justify-center gap-2 disabled:opacity-50" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                            <svg wire:loading class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            <span wire:loading.remove>Check Dates</span>
                            <span wire:loading>Checking...</span>
                        </button>
                    </div>
                </form>

                {{-- Error Message --}}
                @if($errorMessage)
                    <div class="mt-4 p-4 rounded-xl border flex items-center gap-3 animate-fade-in-up" style="background: rgba(239,68,68,0.12); border-color: rgba(239,68,68,0.35);">
                        <svg class="w-5 h-5 shrink-0 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-red-200">{{ $errorMessage }}</p>
                    </div>
                @endif

                {{-- Results --}}
                @if($searched)
                    <div class="mt-6 p-6 rounded-2xl border transition-all duration-500 animate-fade-in-up" style="{{ $isAvailable ? 'background: rgba(34,197,94,0.1); border-color: rgba(34,197,94,0.35);' : 'background: rgba(245,158,11,0.1); border-color: rgba(245,158,11,0.35);' }}">
                        @if($isAvailable)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-md" style="background: rgba(34,197,94,0.2);">
                                        <svg class="w-6 h-6" style="color: #22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-emerald-400">Rooms Available!</h3>
                                        <p class="text-sm text-white/80 mt-1">
                                            <span class="font-bold text-white">{{ $availableCount }}</span> {{ $categoryName }} room{{ $availableCount > 1 ? 's' : '' }} ready for your stay.
                                            Starting at <span class="font-semibold" style="color: #d4a853;">${{ $categoryAmount }}</span> / night.
                                        </p>
                                    </div>
                                </div>
                                @if($selectedCategory)
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('room.details', $selectedCategory) }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white border border-white/30 hover:border-white transition-all text-center">
                                            Details
                                        </a>
                                        <a href="{{ route('checkout', ['roomCategory' => $selectedCategory, 'checkIn' => $checkIn, 'checkOut' => $checkOut]) }}" class="px-6 py-2.5 rounded-xl text-xs font-semibold text-white uppercase tracking-wider transition-all duration-300 hover:scale-105 shadow-lg text-center" style="background: linear-gradient(135deg, #16a34a, #15803d);">
                                            Book Now
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-md" style="background: rgba(245,158,11,0.2);">
                                        <svg class="w-6 h-6" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-amber-400">Fully Booked for These Dates</h3>
                                        <p class="text-sm text-white/80 mt-1">
                                            All <span class="font-semibold text-white">{{ $categoryName }}</span> rooms are currently occupied for the chosen timeframe.
                                        </p>
                                    </div>
                                </div>
                                <a href="#rooms" class="px-6 py-2.5 rounded-xl text-xs font-semibold text-white uppercase tracking-wider transition-all duration-300 hover:scale-105 shadow-md text-center" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                                    Browse Other Rooms
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- ROOM CATEGORIES SHOWCASE --}}
    {{-- ========================================== --}}
    <section id="rooms" class="py-20 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto">
            {{-- Section Header --}}
            <div class="text-center mb-16">
                <p class="text-xs uppercase tracking-[0.3em] font-semibold mb-3" style="color: #d4a853;">Accommodations</p>
                <h2 class="font-playfair text-4xl sm:text-5xl font-bold mb-4" style="color: var(--hotel-heading);">Our Room Categories</h2>
                <div class="w-24 h-px mx-auto mb-6" style="background: linear-gradient(90deg, transparent, #d4a853, transparent);"></div>
                <p class="text-sm sm:text-base max-w-2xl mx-auto leading-relaxed" style="color: var(--hotel-subtext);">
                    Each room is thoughtfully designed to provide the perfect blend of comfort, elegance, and modern luxury.
                </p>
            </div>

            {{-- Room Cards Grid --}}
            @if($categories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($categories as $category)
                        <div class="group flex flex-col rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border" style="background-color: var(--hotel-card); border-color: var(--hotel-border);" wire:key="category-{{ $category->id }}">
                            {{-- Card Image --}}
                            <div class="relative h-64 overflow-hidden">
                                @if($category->images && count($category->images) > 0)
                                    <img src="{{ asset('storage/' . $category->images[0]) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <img src="{{ asset('images/hotel/room.jpg') }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent"></div>
                                
                                <div class="absolute top-4 right-4 px-3.5 py-1.5 rounded-full text-xs font-bold text-white shadow-lg" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                                    From ${{ number_format($category->amount, 0) }}<span class="text-[10px] font-normal opacity-85"> / nt</span>
                                </div>

                                <div class="absolute bottom-3 left-4 right-4 text-white">
                                    <span class="text-[10px] tracking-widest uppercase font-semibold text-amber-400">Suite</span>
                                    <h3 class="font-playfair text-xl font-bold">{{ $category->name }}</h3>
                                </div>
                            </div>

                            {{-- Card Content --}}
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <p class="text-xs sm:text-sm mb-4 line-clamp-2 leading-relaxed" style="color: var(--hotel-subtext);">
                                        {{ $category->description }}
                                    </p>

                                    {{-- Quick Info --}}
                                    <div class="flex items-center gap-4 text-xs mb-4 pb-4 border-b" style="border-color: var(--hotel-border); color: var(--hotel-subtext);">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Up to {{ $category->capacity }} guests
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                            {{ $category->size }} m²
                                        </span>
                                    </div>

                                    {{-- Features Preview --}}
                                    @if($category->features && count($category->features) > 0)
                                        <div class="flex flex-wrap gap-1.5 mb-4">
                                            @foreach(array_slice($category->features, 0, 3) as $feature)
                                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-medium" style="background: rgba(212,168,83,0.1); color: #d4a853;">{{ $feature }}</span>
                                            @endforeach
                                            @if(count($category->features) > 3)
                                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-medium opacity-70" style="background: rgba(212,168,83,0.06); color: #d4a853;">+{{ count($category->features) - 3 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- Action CTAs --}}
                                <div class="pt-4 flex items-center justify-between gap-3">
                                    <a href="{{ route('room.details', $category) }}" class="text-xs font-semibold flex items-center gap-1 hover:underline" style="color: #d4a853;">
                                        View Details
                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>

                                    <a href="{{ route('checkout', $category) }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-white tracking-wider uppercase transition-all duration-300 hover:scale-105 shadow-md" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                                        Reserve
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- HOTEL PHOTO GALLERY SECTION --}}
    {{-- ========================================== --}}
    <section id="gallery" class="py-20 px-4 sm:px-6 lg:px-8 transition-colors duration-300" style="background-color: var(--hotel-card-subtle);">
        <div class="max-w-7xl mx-auto">
            
            {{-- Section Header --}}
            <div class="text-center mb-12">
                <p class="text-xs uppercase tracking-[0.3em] font-semibold mb-3" style="color: #d4a853;">Visual Experience</p>
                <h2 class="font-playfair text-4xl sm:text-5xl font-bold mb-4" style="color: var(--hotel-heading);">Hotel Gallery</h2>
                <div class="w-24 h-px mx-auto mb-6" style="background: linear-gradient(90deg, transparent, #d4a853, transparent);"></div>
                <p class="text-sm sm:text-base max-w-2xl mx-auto leading-relaxed" style="color: var(--hotel-subtext);">
                    Immerse yourself in the timeless beauty, architecture, and luxury atmospheres of Grand Horizon Hotel & Suites.
                </p>
            </div>

            {{-- Gallery Tabs --}}
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-3 mb-10">
                <button @click="galleryFilter = 'all'" :class="galleryFilter === 'all' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-amber-500'" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-300">
                    All Highlights
                </button>
                <button @click="galleryFilter = 'exterior'" :class="galleryFilter === 'exterior' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-amber-500'" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-300">
                    Exterior & Views
                </button>
                <button @click="galleryFilter = 'suites'" :class="galleryFilter === 'suites' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-amber-500'" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-300">
                    Suites & Rooms
                </button>
                <button @click="galleryFilter = 'lobby'" :class="galleryFilter === 'lobby' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-amber-500'" class="px-5 py-2 rounded-full text-xs font-semibold transition-all duration-300">
                    Lobby & Lounges
                </button>
            </div>

            {{-- Gallery Grid --}}
            @php
                $galleryItems = [
                    [
                        'image' => asset('images/hotel/hero_night.jpg'),
                        'category' => 'exterior',
                        'title' => 'Twilight Resort Exterior',
                        'desc' => 'Illuminated contemporary architecture with reflecting pools and ocean breeze.'
                    ],
                    [
                        'image' => asset('images/hotel/gallery_deluxe.jpg'),
                        'category' => 'suites',
                        'title' => 'Ocean View Deluxe Balcony',
                        'desc' => 'Panoramic sea vistas with plush loungers and private terrace.'
                    ],
                    [
                        'image' => asset('images/hotel/gallery_penthouse.jpg'),
                        'category' => 'suites',
                        'title' => 'Presidential Penthouse & Jacuzzi',
                        'desc' => 'Skyline jacuzzi, crystal chandelier, and duplex living space.'
                    ],
                    [
                        'image' => asset('images/hotel/gallery_lobby.jpg'),
                        'category' => 'lobby',
                        'title' => 'Grand Crystal Chandelier Lounge',
                        'desc' => 'Velvet seating and marble accents for refined socializing.'
                    ],
                    [
                        'image' => asset('images/hotel/gallery_executive.jpg'),
                        'category' => 'suites',
                        'title' => 'Executive King Workspace',
                        'desc' => 'High-speed business suite with skyline panorama and espresso bar.'
                    ],
                    [
                        'image' => asset('images/hotel/gallery_bedroom.jpg'),
                        'category' => 'suites',
                        'title' => 'Signature Luxury Suite Bedroom',
                        'desc' => 'Warm ambient illumination with custom artisan woodwork.'
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($galleryItems as $item)
                    <div x-show="galleryFilter === 'all' || galleryFilter === '{{ $item['category'] }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         @click="openLightbox('{{ $item['image'] }}', '{{ addslashes($item['title']) }}', '{{ addslashes($item['desc']) }}')"
                         class="group relative h-72 sm:h-80 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500 border border-black/5 dark:border-white/10">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent opacity-80 group-hover:opacity-95 transition-opacity"></div>
                        
                        {{-- Hover overlay zoom icon --}}
                        <div class="absolute top-4 right-4 w-9 h-9 rounded-full flex items-center justify-center text-white bg-black/40 backdrop-blur-md opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                        </div>

                        {{-- Caption --}}
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <span class="text-[10px] uppercase tracking-widest font-semibold text-amber-400 block mb-1">{{ ucfirst($item['category']) }}</span>
                            <h3 class="font-playfair text-lg font-bold">{{ $item['title'] }}</h3>
                            <p class="text-xs text-white/75 mt-1 line-clamp-1 group-hover:line-clamp-none transition-all">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- LIGHTBOX MODAL --}}
        <div x-show="lightboxOpen" x-cloak 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" style="background: rgba(0,0,0,0.92); backdrop-filter: blur(15px);"
             @keydown.escape.window="lightboxOpen = false">
            <div class="relative max-w-5xl w-full max-h-[90vh] flex flex-col items-center">
                {{-- Close button --}}
                <button @click="lightboxOpen = false" class="absolute -top-12 right-0 sm:-right-4 text-white/80 hover:text-white p-2" aria-label="Close lightbox">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <img :src="lightboxImage" :alt="lightboxTitle" class="max-h-[75vh] w-auto max-w-full rounded-2xl object-contain shadow-2xl border border-white/10">

                <div class="text-center mt-4 text-white">
                    <h3 class="font-playfair text-xl font-bold" x-text="lightboxTitle"></h3>
                    <p class="text-xs sm:text-sm text-white/70 mt-1 max-w-lg mx-auto" x-text="lightboxDesc"></p>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- AMENITIES SECTION --}}
    {{-- ========================================== --}}
    <section id="amenities" class="py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden" style="background: var(--hotel-navy);">
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <p class="text-xs uppercase tracking-[0.3em] font-semibold mb-3" style="color: #d4a853;">What We Offer</p>
                <h2 class="font-playfair text-4xl sm:text-5xl font-bold text-white mb-4">Hotel Amenities</h2>
                <div class="w-24 h-px mx-auto mb-6" style="background: linear-gradient(90deg, transparent, #d4a853, transparent);"></div>
                <p class="text-sm sm:text-base text-white/60 max-w-2xl mx-auto">Indulge in our world-class facilities designed to make your stay extraordinary.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $amenities = [
                        ['icon' => 'pool', 'name' => 'Infinity Pool', 'desc' => 'Rooftop pool with panoramic ocean views'],
                        ['icon' => 'spa', 'name' => 'Luxury Spa', 'desc' => 'Full-service massage & thermal baths'],
                        ['icon' => 'restaurant', 'name' => 'Fine Dining', 'desc' => 'Award-winning Michelin star cuisine'],
                        ['icon' => 'gym', 'name' => 'Fitness Center', 'desc' => '24/7 state-of-the-art gym'],
                        ['icon' => 'wifi', 'name' => 'Fiber WiFi', 'desc' => 'Ultra high-speed in all areas'],
                        ['icon' => 'parking', 'name' => 'Valet Parking', 'desc' => 'Secure covered underground valet'],
                        ['icon' => 'concierge', 'name' => 'Butler & Concierge', 'desc' => 'Personalized round-the-clock service'],
                        ['icon' => 'laundry', 'name' => 'Express Laundry', 'desc' => 'Same-day dry cleaning & pressing'],
                    ];
                @endphp

                @foreach($amenities as $amenity)
                    <div class="group p-6 rounded-2xl border text-center transition-all duration-500 hover:border-amber-500/50 hover:shadow-[0_0_30px_rgba(212,168,83,0.15)] hover:-translate-y-1" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08);">
                        <div class="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center transition-all duration-300 group-hover:scale-110 shadow-inner" style="background: rgba(212,168,83,0.12);">
                            <svg class="w-7 h-7" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                @switch($amenity['icon'])
                                    @case('pool')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 17.25V21h18v-3.75M3 17.25c1.5 0 3-.75 3-2.25s1.5-2.25 3-2.25 3 .75 3 2.25 1.5 2.25 3 2.25 3-.75 3-2.25 1.5-2.25 3-2.25v4.5"/>
                                        @break
                                    @case('spa')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                        @break
                                    @case('restaurant')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5"/>
                                        @break
                                    @case('gym')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h1.5m15 0H21m-3-4.5v9m-12-9v9M5.25 8.625c0-.621.504-1.125 1.125-1.125h1.5c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125h-1.5a1.125 1.125 0 01-1.125-1.125v-6.75z"/>
                                        @break
                                    @case('wifi')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z"/>
                                        @break
                                    @case('parking')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25"/>
                                        @break
                                    @case('concierge')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                                        @break
                                    @case('laundry')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                                        @break
                                @endswitch
                            </svg>
                        </div>
                        <h3 class="font-semibold text-white text-sm mb-1">{{ $amenity['name'] }}</h3>
                        <p class="text-xs text-white/50">{{ $amenity['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- ABOUT SECTION --}}
    {{-- ========================================== --}}
    <section id="about" class="py-20 px-4 sm:px-6 lg:px-8 transition-colors duration-300" style="background-color: var(--hotel-bg);">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Image --}}
                <div class="relative">
                    <div class="rounded-3xl overflow-hidden shadow-2xl border" style="border-color: var(--hotel-border);">
                        <img src="{{ asset('images/hotel/about.jpg') }}" alt="Grand Horizon Hotel elegant lounge interior" class="w-full h-[420px] lg:h-[520px] object-cover">
                    </div>
                    {{-- Floating Stats Card --}}
                    <div class="absolute -bottom-6 -right-4 sm:right-8 glass-dark rounded-2xl p-6 shadow-2xl border" style="border-color: rgba(212,168,83,0.25); min-width: 210px;">
                        <div class="text-center">
                            <p class="font-playfair text-3xl font-bold" style="color: #d4a853;">15+</p>
                            <p class="text-xs text-white/80 mt-1 uppercase tracking-wider">Years of Luxury Hospitality</p>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] font-semibold mb-3" style="color: #d4a853;">Our Story</p>
                    <h2 class="font-playfair text-4xl sm:text-5xl font-bold mb-6" style="color: var(--hotel-heading);">A Legacy of <br><span class="italic text-amber-500">Luxury</span> & Comfort</h2>
                    <div class="w-16 h-px mb-8" style="background: linear-gradient(90deg, #d4a853, transparent);"></div>

                    <p class="mb-6 leading-relaxed text-sm sm:text-base" style="color: var(--hotel-subtext);">
                        Overlooking pristine ocean horizons, Grand Horizon Hotel & Suites has been setting the benchmark for refined hospitality since 2010. Every architectural detail, culinary creation, and guest experience has been thoughtfully orchestrated.
                    </p>
                    <p class="mb-8 leading-relaxed text-sm sm:text-base" style="color: var(--hotel-subtext);">
                        Whether visiting for business conferences, romantic getaways, or restorative spa holidays, our dedicated concierge and tailored services ensure your stay is completely seamless and memorable.
                    </p>

                    {{-- Stats Row --}}
                    <div class="grid grid-cols-3 gap-6 pt-4 border-t" style="border-color: var(--hotel-border);">
                        <div>
                            <p class="font-playfair text-3xl font-bold" style="color: #d4a853;">200+</p>
                            <p class="text-xs mt-1" style="color: var(--hotel-subtext);">Luxury Rooms</p>
                        </div>
                        <div>
                            <p class="font-playfair text-3xl font-bold" style="color: #d4a853;">50K+</p>
                            <p class="text-xs mt-1" style="color: var(--hotel-subtext);">Satisfied Guests</p>
                        </div>
                        <div>
                            <p class="font-playfair text-3xl font-bold" style="color: #d4a853;">4.9</p>
                            <p class="text-xs mt-1" style="color: var(--hotel-subtext);">Star Rating</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- FOOTER --}}
    {{-- ========================================== --}}
    <footer id="contact" class="pt-16 pb-8 px-4 sm:px-6 lg:px-8 transition-colors duration-300" style="background: var(--hotel-navy);">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                {{-- Brand --}}
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #d4a853, #e8c878);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-white font-playfair text-lg font-semibold">Grand Horizon</span>
                            <span class="block text-[10px] tracking-[0.2em] uppercase" style="color: #d4a853;">Hotel & Suites</span>
                        </div>
                    </div>
                    <p class="text-xs text-white/50 leading-relaxed">Experience luxury redefined at Grand Horizon Hotel & Suites. Where every moment becomes an unforgettable memory.</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-white font-semibold mb-4 text-xs tracking-wider uppercase">Navigation</h4>
                    <ul class="space-y-3 text-xs text-white/60">
                        <li><a href="#rooms" class="hover:text-amber-400 transition-colors">Room Categories</a></li>
                        <li><a href="#gallery" class="hover:text-amber-400 transition-colors">Hotel Gallery</a></li>
                        <li><a href="#amenities" class="hover:text-amber-400 transition-colors">Amenities & Spa</a></li>
                        <li><a href="#availability" class="hover:text-amber-400 transition-colors">Direct Reservation</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-white font-semibold mb-4 text-xs tracking-wider uppercase">Contact Desk</h4>
                    <ul class="space-y-3 text-xs text-white/60">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            <span>123 Luxury Coastal Blvd, Waterfront</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <span>reservations@grandhorizon.com</span>
                        </li>
                    </ul>
                </div>

                {{-- Social & Hours --}}
                <div>
                    <h4 class="text-white font-semibold mb-4 text-xs tracking-wider uppercase">Check-In Info</h4>
                    <p class="text-xs text-white/50 leading-relaxed mb-4">
                        Front Desk & Concierge: Open 24/7<br>
                        Check-in: 2:00 PM | Check-out: 11:00 AM
                    </p>
                    <div class="flex gap-2.5">
                        @foreach(['facebook', 'instagram', 'twitter'] as $social)
                            <a href="#" class="w-9 h-9 rounded-full flex items-center justify-center border transition-all duration-300 hover:scale-110" style="border-color: rgba(212,168,83,0.3); background: rgba(212,168,83,0.08);" aria-label="{{ $social }}">
                                @switch($social)
                                    @case('facebook')
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        @break
                                    @case('instagram')
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                        @break
                                    @case('twitter')
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        @break
                                @endswitch
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Bottom Copyright --}}
            <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/40">
                <p>&copy; {{ date('Y') }} Grand Horizon Hotel & Suites. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="{{ route('privacy') }}" class="hover:text-amber-400 transition-colors">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="hover:text-amber-400 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</div>
