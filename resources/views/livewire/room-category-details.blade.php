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
    {{-- NAVIGATION BAR (Compact) --}}
    {{-- ========================================== --}}
    <nav class="fixed top-0 left-0 right-0 z-50 shadow-lg transition-colors duration-300" style="background: rgba(15, 23, 42, 0.97); backdrop-filter: blur(20px);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #d4a853, #e8c878);">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/>
                        </svg>
                    </div>
                    <span class="text-white font-playfair text-base font-semibold tracking-wide">Grand Horizon</span>
                </a>

                {{-- Action items --}}
                <div class="flex items-center gap-4">
                    {{-- Dark Mode Toggle --}}
                    <button @click="toggleDarkMode()" class="p-2 rounded-full border text-white/80 hover:text-white transition-all duration-300" style="border-color: rgba(212,168,83,0.3); background: rgba(255,255,255,0.05);" title="Toggle Dark/Light Mode" aria-label="Toggle theme">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    {{-- Back Link --}}
                    <a href="{{ route('home') }}#rooms" class="flex items-center gap-2 text-sm text-white/70 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back to Rooms
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- ========================================== --}}
    {{-- IMAGE CAROUSEL --}}
    {{-- ========================================== --}}
    <section class="pt-16" x-data="{
        currentSlide: 0,
        totalSlides: {{ $roomCategory->images && count($roomCategory->images) > 0 ? count($roomCategory->images) : 1 }},
        autoPlay: null,
        startAutoPlay() {
            this.autoPlay = setInterval(() => { this.nextSlide() }, 5000);
        },
        stopAutoPlay() {
            clearInterval(this.autoPlay);
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        goTo(index) {
            this.currentSlide = index;
            this.stopAutoPlay();
            this.startAutoPlay();
        }
    }" x-init="startAutoPlay()" @mouseenter="stopAutoPlay()" @mouseleave="startAutoPlay()">
        <div class="relative h-[50vh] sm:h-[60vh] lg:h-[70vh] overflow-hidden bg-gray-900">
            {{-- Slides --}}
            @if($roomCategory->images && count($roomCategory->images) > 0)
                @foreach($roomCategory->images as $index => $image)
                    <div class="absolute inset-0 transition-all duration-700 ease-in-out"
                         :class="currentSlide === {{ $index }} ? 'opacity-100 scale-100' : 'opacity-0 scale-105'"
                         :style="currentSlide === {{ $index }} ? 'z-index: 10' : 'z-index: 0'">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $roomCategory->name }} - Image {{ $index + 1 }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-linear-to-t from-black/50 via-transparent to-black/20"></div>
                    </div>
                @endforeach
            @else
                <div class="absolute inset-0">
                    <img src="{{ asset('images/hotel/room.jpg') }}" alt="{{ $roomCategory->name }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-linear-to-t from-black/50 via-transparent to-black/20"></div>
                </div>
            @endif

            {{-- Prev/Next Controls --}}
            @if($roomCategory->images && count($roomCategory->images) > 1)
                <button @click="prevSlide(); stopAutoPlay(); startAutoPlay();" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110" style="background: rgba(15,23,42,0.5); backdrop-filter: blur(10px);" aria-label="Previous image">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="nextSlide(); stopAutoPlay(); startAutoPlay();" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110" style="background: rgba(15,23,42,0.5); backdrop-filter: blur(10px);" aria-label="Next image">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                {{-- Dot Indicators --}}
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                    @foreach($roomCategory->images as $index => $image)
                        <button @click="goTo({{ $index }})" class="transition-all duration-300 rounded-full" :class="currentSlide === {{ $index }} ? 'w-8 h-2.5' : 'w-2.5 h-2.5 hover:scale-125'" :style="currentSlide === {{ $index }} ? 'background: #d4a853;' : 'background: rgba(255,255,255,0.5);'" aria-label="Go to image {{ $index + 1 }}"></button>
                    @endforeach
                </div>

                {{-- Slide Counter --}}
                <div class="absolute top-6 right-6 z-20 px-3 py-1.5 rounded-full text-xs font-medium text-white" style="background: rgba(15,23,42,0.6); backdrop-filter: blur(10px);">
                    <span x-text="currentSlide + 1"></span> / {{ count($roomCategory->images) }}
                </div>
            @endif

            {{-- Room Name Overlay --}}
            <div class="absolute bottom-0 left-0 right-0 z-20 p-6 sm:p-10">
                <div class="max-w-7xl mx-auto">
                    <p class="text-xs tracking-[0.3em] uppercase font-medium mb-2" style="color: #d4a853;">Room Category</p>
                    <h1 class="font-playfair text-3xl sm:text-4xl lg:text-5xl font-bold text-white">{{ $roomCategory->name }}</h1>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- ROOM INFO BAR --}}
    {{-- ========================================== --}}
    <section class="border-b" style="background: var(--hotel-navy); border-color: rgba(212,168,83,0.2);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-6 sm:gap-10">
                    {{-- Price --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(212,168,83,0.15);">
                            <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-white/50">Price per night</p>
                            <p class="text-lg font-semibold" style="color: #d4a853;">${{ number_format($roomCategory->amount, 2) }}</p>
                        </div>
                    </div>

                    {{-- Capacity --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(212,168,83,0.15);">
                            <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-white/50">Capacity</p>
                            <p class="text-lg font-semibold text-white">{{ $roomCategory->capacity }} {{ $roomCategory->capacity > 1 ? 'Guests' : 'Guest' }}</p>
                        </div>
                    </div>

                    {{-- Room Size --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(212,168,83,0.15);">
                            <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-white/50">Room Size</p>
                            <p class="text-lg font-semibold text-white">{{ $roomCategory->size }} m²</p>
                        </div>
                    </div>
                </div>

                {{-- Quick Book CTA --}}
                <a href="#check-availability" class="px-6 py-2.5 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:scale-105 hover:shadow-lg hidden sm:inline-flex items-center gap-2" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    Check Availability
                </a>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================== --}}
    <section class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8" style="background-color: var(--hotel-cream);">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-14">

                {{-- Left Column: Description + Amenities --}}
                <div class="lg:col-span-2 space-y-12">

                    {{-- Description --}}
                    <div>
                        <h2 class="font-playfair text-3xl font-bold mb-2" style="color: var(--hotel-navy);">About This Room</h2>
                        <div class="w-16 h-px mb-6" style="background: linear-gradient(90deg, #d4a853, transparent);"></div>
                        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                            <p>{{ $roomCategory->description }}</p>
                        </div>
                    </div>

                    {{-- Amenities / Features --}}
                    @if($roomCategory->features && count($roomCategory->features) > 0)
                        <div>
                            <h2 class="font-playfair text-3xl font-bold mb-2" style="color: var(--hotel-navy);">Room Amenities</h2>
                            <div class="w-16 h-px mb-6" style="background: linear-gradient(90deg, #d4a853, transparent);"></div>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach($roomCategory->features as $feature)
                                    <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 group">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 transition-all duration-300 group-hover:scale-110" style="background: rgba(212,168,83,0.1);">
                                            {{-- Dynamic icon based on feature name --}}
                                            @php $featureLower = strtolower($feature); @endphp
                                            @if(str_contains($featureLower, 'wifi') || str_contains($featureLower, 'internet'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z"/></svg>
                                            @elseif(str_contains($featureLower, 'tv') || str_contains($featureLower, 'television'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10.125-3h17.25c.621 0 1.125-.504 1.125-1.125V4.875c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125z"/></svg>
                                            @elseif(str_contains($featureLower, 'air') || str_contains($featureLower, 'ac') || str_contains($featureLower, 'conditioning'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                                            @elseif(str_contains($featureLower, 'bar') || str_contains($featureLower, 'wine') || str_contains($featureLower, 'mini'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg>
                                            @elseif(str_contains($featureLower, 'service') || str_contains($featureLower, 'bell') || str_contains($featureLower, 'room service'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                            @elseif(str_contains($featureLower, 'pool') || str_contains($featureLower, 'swim'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 17.25V21h18v-3.75M3 17.25c1.5 0 3-.75 3-2.25s1.5-2.25 3-2.25 3 .75 3 2.25 1.5 2.25 3 2.25 3-.75 3-2.25 1.5-2.25 3-2.25v4.5"/></svg>
                                            @elseif(str_contains($featureLower, 'spa') || str_contains($featureLower, 'wellness'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                            @elseif(str_contains($featureLower, 'gym') || str_contains($featureLower, 'fitness'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12h1.5m15 0H21m-3-4.5v9m-12-9v9M5.25 8.625c0-.621.504-1.125 1.125-1.125h1.5c.621 0 1.125.504 1.125 1.125v6.75c0 .621-.504 1.125-1.125 1.125h-1.5a1.125 1.125 0 01-1.125-1.125v-6.75z"/></svg>
                                            @elseif(str_contains($featureLower, 'parking') || str_contains($featureLower, 'car'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25"/></svg>
                                            @elseif(str_contains($featureLower, 'safe') || str_contains($featureLower, 'lock') || str_contains($featureLower, 'security'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            @elseif(str_contains($featureLower, 'balcon') || str_contains($featureLower, 'terrace'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/></svg>
                                            @elseif(str_contains($featureLower, 'view') || str_contains($featureLower, 'ocean') || str_contains($featureLower, 'sea') || str_contains($featureLower, 'city'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            @elseif(str_contains($featureLower, 'breakfast') || str_contains($featureLower, 'coffee') || str_contains($featureLower, 'tea'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513M6 13.12v5.38m12-5.38v5.38"/></svg>
                                            @elseif(str_contains($featureLower, 'bath') || str_contains($featureLower, 'tub') || str_contains($featureLower, 'jacuzzi'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636"/></svg>
                                            @elseif(str_contains($featureLower, 'shower'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5"/></svg>
                                            @elseif(str_contains($featureLower, 'laundry') || str_contains($featureLower, 'iron'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                                            @elseif(str_contains($featureLower, 'desk') || str_contains($featureLower, 'work') || str_contains($featureLower, 'office'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>
                                            @elseif(str_contains($featureLower, 'phone') || str_contains($featureLower, 'telephone'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                            @elseif(str_contains($featureLower, 'restaurant') || str_contains($featureLower, 'dining'))
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5"/></svg>
                                            @else
                                                {{-- Default check icon --}}
                                                <svg class="w-5 h-5" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @endif
                                        </div>
                                        <span class="text-sm font-medium" style="color: var(--hotel-navy);">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right Column: Availability Checker (Sticky) --}}
                <div class="lg:col-span-1">
                    <div id="check-availability" class="lg:sticky lg:top-24">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                            {{-- Header --}}
                            <div class="p-6" style="background: var(--hotel-navy);">
                                <h3 class="font-playfair text-xl font-semibold text-white text-center">Check Availability</h3>
                                <p class="text-center text-xs text-white/50 mt-1">Select your dates to check room availability</p>
                            </div>

                            {{-- Form --}}
                            <div class="p-6 space-y-5">
                                {{-- Check-in --}}
                                <div>
                                    <label for="detail-checkin" class="block text-sm font-medium mb-2" style="color: var(--hotel-navy);">Check-in Date</label>
                                    <input type="date" wire:model="checkIn" id="detail-checkin" min="{{ now()->format('Y-m-d') }}" class="w-full rounded-xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 transition-all" style="border-color: #e5e7eb; --tw-ring-color: #d4a853;">
                                </div>

                                {{-- Check-out --}}
                                <div>
                                    <label for="detail-checkout" class="block text-sm font-medium mb-2" style="color: var(--hotel-navy);">Check-out Date</label>
                                    <input type="date" wire:model="checkOut" id="detail-checkout" min="{{ now()->addDay()->format('Y-m-d') }}" class="w-full rounded-xl border px-4 py-3 text-sm focus:outline-none focus:ring-2 transition-all" style="border-color: #e5e7eb; --tw-ring-color: #d4a853;">
                                </div>

                                {{-- Price Info --}}
                                <div class="p-4 rounded-xl" style="background: rgba(212,168,83,0.06); border: 1px solid rgba(212,168,83,0.15);">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Price per night</span>
                                        <span class="text-lg font-bold" style="color: #d4a853;">${{ number_format($roomCategory->amount, 2) }}</span>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <button wire:click="checkAvailability" class="w-full rounded-xl px-6 py-3.5 text-sm font-semibold text-white tracking-wide uppercase transition-all duration-300 hover:scale-[1.02] hover:shadow-lg flex items-center justify-center gap-2" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                                    <svg wire:loading wire:target="checkAvailability" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                    <span wire:loading.remove wire:target="checkAvailability">Check Availability</span>
                                    <span wire:loading wire:target="checkAvailability">Checking...</span>
                                </button>

                                {{-- Error Message --}}
                                @if($errorMessage)
                                    <div class="p-4 rounded-xl border flex items-start gap-3" style="background: #fef2f2; border-color: #fecaca;">
                                        <svg class="w-5 h-5 shrink-0 mt-0.5" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-sm" style="color: #b91c1c;">{{ $errorMessage }}</p>
                                    </div>
                                @endif

                                {{-- Availability Results --}}
                                @if($searched)
                                    <div class="transition-all duration-500">
                                        @if($isAvailable)
                                            {{-- ✅ AVAILABLE --}}
                                            <div class="p-5 rounded-xl border" style="background: #f0fdf4; border-color: #bbf7d0;">
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: #dcfce7;">
                                                        <svg class="w-5 h-5" style="color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold" style="color: #16a34a;">Rooms Available!</h4>
                                                        <p class="text-xs text-gray-500">{{ $availableCount }} room{{ $availableCount > 1 ? 's' : '' }} available</p>
                                                    </div>
                                                </div>

                                                {{-- Pricing Breakdown --}}
                                                <div class="space-y-2 pt-4 border-t border-green-200">
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">${{ number_format($roomCategory->amount, 2) }} × {{ $totalNights }} night{{ $totalNights > 1 ? 's' : '' }}</span>
                                                        <span class="font-medium" style="color: var(--hotel-navy);">${{ $totalPrice }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm pt-2 border-t border-green-100">
                                                        <span class="font-semibold" style="color: var(--hotel-navy);">Total</span>
                                                        <span class="font-bold text-lg" style="color: #d4a853;">${{ $totalPrice }}</span>
                                                    </div>
                                                </div>

                                                {{-- Book Now Button --}}
                                                <a href="{{ route('checkout', ['roomCategory' => $roomCategory->id, 'checkIn' => $checkIn, 'checkOut' => $checkOut]) }}" class="w-full mt-4 inline-flex items-center justify-center rounded-xl px-6 py-3.5 text-sm font-semibold text-white tracking-wide uppercase transition-all duration-300 hover:scale-[1.02] hover:shadow-lg" style="background: linear-gradient(135deg, #16a34a, #15803d);">
                                                    Proceed to Checkout — ${{ $totalPrice }}
                                                </a>
                                            </div>
                                        @else
                                            {{-- ❌ NOT AVAILABLE --}}
                                            <div class="p-5 rounded-xl border" style="background: rgba(245,158,11,0.08); border-color: rgba(245,158,11,0.3);">
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: rgba(245,158,11,0.15);">
                                                        <svg class="w-5 h-5" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold" style="color: #f59e0b;">No Rooms Available</h4>
                                                        <p class="text-xs text-gray-500">All rooms booked for selected dates</p>
                                                    </div>
                                                </div>

                                                <p class="text-sm mb-4" style="color: var(--hotel-subtext);">
                                                    All {{ $roomCategory->name }} rooms are fully booked from {{ \Carbon\Carbon::parse($checkIn)->format('M d') }} to {{ \Carbon\Carbon::parse($checkOut)->format('M d, Y') }}.
                                                </p>

                                                {{-- Suggestions --}}
                                                <div class="p-3 rounded-lg mb-4" style="background: rgba(217,119,6,0.06); border: 1px solid rgba(217,119,6,0.15);">
                                                    <p class="text-xs font-semibold mb-2" style="color: #d4a853;">💡 Suggestions:</p>
                                                    <ul class="text-xs space-y-1" style="color: var(--hotel-subtext);">
                                                        <li class="flex items-center gap-2">
                                                            <svg class="w-3 h-3 shrink-0" style="color: #d97706;" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                                            Try adjusting your dates by a few days
                                                        </li>
                                                        <li class="flex items-center gap-2">
                                                            <svg class="w-3 h-3 shrink-0" style="color: #d97706;" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                                            Check our other room categories
                                                        </li>
                                                        <li class="flex items-center gap-2">
                                                            <svg class="w-3 h-3 shrink-0" style="color: #d97706;" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                                            Contact us for waitlist options
                                                        </li>
                                                    </ul>
                                                </div>

                                                <a href="{{ route('home') }}#rooms" class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:scale-[1.02]" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                                                    Browse Other Rooms
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Help Card --}}
                        <div class="mt-6 p-5 rounded-2xl shadow-sm border text-center transition-colors duration-300" style="background-color: var(--hotel-card); border-color: var(--hotel-border);">
                            <div class="w-12 h-12 rounded-full mx-auto mb-3 flex items-center justify-center" style="background: rgba(212,168,83,0.1);">
                                <svg class="w-6 h-6" style="color: #d4a853;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            </div>
                            <h4 class="font-semibold text-sm mb-1" style="color: var(--hotel-heading);">Need Help?</h4>
                            <p class="text-xs mb-3" style="color: var(--hotel-subtext);">Our team is available 24/7</p>
                            <a href="tel:+15551234567" class="text-sm font-semibold hover:underline" style="color: #d4a853;">+1 (555) 123-4567</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- FOOTER (Compact) --}}
    {{-- ========================================== --}}
    <footer class="py-8 px-4 sm:px-6 lg:px-8" style="background: var(--hotel-navy);">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #d4a853, #e8c878);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/>
                    </svg>
                </div>
                <span class="text-white font-playfair text-sm font-semibold">Grand Horizon Hotel & Suites</span>
            </a>
            <div class="flex items-center gap-6 text-xs text-white/50">
                <a href="{{ route('privacy') }}" class="hover:text-amber-400 transition-colors">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="hover:text-amber-400 transition-colors">Terms of Service</a>
                <span>&copy; {{ date('Y') }} All rights reserved.</span>
            </div>
        </div>
    </footer>
</div>
