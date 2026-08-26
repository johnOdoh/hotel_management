@props([
    'mobile' => false,
])

@guest
    @if($mobile)
        <a href="{{ route('filament.user.auth.login') }}"
           @click="mobileOpen = false"
           class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold text-white border transition-all duration-300 shadow-sm"
           style="border-color: rgba(212, 168, 83, 0.4); background: rgba(212, 168, 83, 0.15);">
            <svg class="w-4 h-4 text-[#d4a853]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            <span>Sign In</span>
        </a>
    @else
        <a href="{{ route('filament.user.auth.login') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs sm:text-sm font-medium text-white/90 hover:text-white border transition-all duration-300 hover:scale-105 shadow-sm hover:shadow-[0_0_15px_rgba(212,168,83,0.3)]"
           style="border-color: rgba(212, 168, 83, 0.4); background: rgba(212, 168, 83, 0.12); backdrop-filter: blur(8px);">
            <svg class="w-4 h-4 text-[#d4a853]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            <span>Sign In</span>
        </a>
    @endif
@else
    @if($mobile)
        <div class="pt-3 mt-1 border-t border-white/10 flex flex-col gap-2">
            <div class="flex items-center gap-3 px-2 py-1.5 rounded-xl" style="background: rgba(255, 255, 255, 0.05);">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-md shrink-0" style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <div class="truncate flex-1">
                    <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}"
               @click="mobileOpen = false"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 transition-colors">
                <svg class="w-4 h-4 text-[#d4a853]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <span>Profile</span>
            </a>

            @if(Route::has('filament.user.pages.dashboard'))
                <a href="{{ route('filament.user.pages.dashboard') }}"
                   @click="mobileOpen = false"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4 text-[#d4a853]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-red-400 hover:bg-red-500/10 transition-colors text-left">
                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    @else
        <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false" @keydown.escape.window="userMenuOpen = false">
            <button @click="userMenuOpen = !userMenuOpen"
                    type="button"
                    class="group flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-full text-xs sm:text-sm font-medium text-white transition-all duration-300 border hover:scale-[1.02] focus:outline-none shadow-sm"
                    style="border-color: rgba(212, 168, 83, 0.35); background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(10px);"
                    aria-expanded="false"
                    :aria-expanded="userMenuOpen.toString()">

                {{-- User Icon Avatar --}}
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-md shrink-0 transition-transform duration-300 group-hover:scale-105"
                     style="background: linear-gradient(135deg, #d4a853, #b8922f);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>

                {{-- User Name --}}
                <span class="max-w-30 lg:max-w-40 truncate font-medium text-white/95 tracking-wide">{{ auth()->user()->name }}</span>

                {{-- Chevron Arrow --}}
                <svg class="w-3.5 h-3.5 text-[#d4a853] transition-transform duration-300"
                     :class="userMenuOpen ? 'rotate-180' : ''"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="userMenuOpen"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="absolute right-0 mt-2 w-60 rounded-2xl shadow-2xl py-2 z-50 border overflow-hidden"
                 style="background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(25px); border-color: rgba(212, 168, 83, 0.25); box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.6), 0 0 20px rgba(212, 168, 83, 0.15);">

                {{-- Header with User Info --}}
                <div class="px-4 py-3 border-b" style="border-color: rgba(212, 168, 83, 0.15);">
                    <div class="text-[10px] font-semibold uppercase tracking-[0.2em]" style="color: #d4a853;">Signed in as</div>
                    <div class="text-sm font-semibold text-white truncate mt-0.5">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</div>
                </div>

                {{-- Action Links --}}
                <div class="py-1.5">
                    {{-- Dashboard (if available) --}}
                    @if(Route::has('filament.user.pages.dashboard'))
                        <a href="{{ route('filament.user.pages.dashboard') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-200 hover:text-white hover:bg-white/10 transition-colors">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center" style="background: rgba(212, 168, 83, 0.15); color: #d4a853;">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>
                            </div>
                            <span>Dashboard</span>
                        </a>
                    @endif
                </div>

                {{-- Logout Button --}}
                <div class="border-t pt-1.5" style="border-color: rgba(212, 168, 83, 0.15);">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors text-left cursor-pointer">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center bg-red-500/10 text-red-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                            </div>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endguest
