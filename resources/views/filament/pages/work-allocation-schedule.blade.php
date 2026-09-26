<x-filament-panels::page>
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 8mm;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
            body * {
                visibility: hidden !important;
            }
            #calendar-export-area, #calendar-export-area * {
                visibility: visible !important;
            }
            #calendar-export-area {
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                width: 100vw !important;
                margin: 0 !important;
                padding: 12px !important;
                background: white !important;
                color: black !important;
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
            #calendar-export-area .grid {
                display: grid !important;
                grid-template-columns: repeat(7, minmax(0, 1fr)) !important;
                gap: 8px !important;
            }
            [data-html2canvas-ignore], .no-export {
                display: none !important;
            }
        }
    </style>

    <div x-data="workScheduleExporter" class="space-y-6">
        <!-- Control & Navigation Bar -->
        <div class="bg-white dark:bg-gray-900 border border-gray-200/80 dark:border-gray-800 rounded-2xl p-4 shadow-xs">

            <!-- Top Controls Row -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                <!-- Week Navigation Buttons -->
                <div class="flex items-center gap-2">
                    <x-filament::button
                        wire:click="previousWeek"
                        size="sm"
                        color="gray"
                        icon="heroicon-m-chevron-left"
                    >
                        Prev
                    </x-filament::button>

                    <x-filament::button
                        wire:click="currentWeek"
                        size="sm"
                        color="gray"
                    >
                        Current Week
                    </x-filament::button>

                    <x-filament::button
                        wire:click="nextWeek"
                        size="sm"
                        color="gray"
                        icon="heroicon-m-chevron-right"
                        icon-position="after"
                    >
                        Next
                    </x-filament::button>
                </div>

                <!-- Date Range Title -->
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-900 dark:text-white flex items-center justify-center gap-2">
                        <x-filament::icon icon="heroicon-m-calendar" class="w-5 h-5 text-primary-500" />
                        <span>{{ $startOfWeek->format('M d') }} &ndash; {{ $endOfWeek->format('M d, Y') }}</span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        <span class="font-semibold text-primary-600 dark:text-primary-400">{{ $selectedPosition }}</span> &bull; {{ $totalShiftsCount }} {{ \Illuminate\Support\Str::plural('shift', $totalShiftsCount) }} scheduled
                    </p>
                </div>

                <!-- Actions: Download & Assign -->
                <div class="flex items-center gap-2.5">
                    <x-filament::button
                        type="button"
                        x-on:click="downloadCalendar('{{ \Illuminate\Support\Str::slug($selectedPosition) }}', '{{ $startOfWeek->format('Y-m-d') }}')"
                        x-bind:disabled="exporting"
                        size="sm"
                        color="gray"
                        icon="heroicon-m-arrow-down-tray"
                    >
                        <span x-text="exporting ? 'Exporting...' : 'Download'">Download</span>
                    </x-filament::button>

                    <x-filament::button
                        wire:click="mountAction('assignShift', { date: '{{ now()->toDateString() }}' })"
                        size="sm"
                        icon="heroicon-m-plus"
                    >
                        Assign Shift
                    </x-filament::button>
                </div>
            </div>

            <!-- Position Filter Tabs (Strictly Position enum) -->
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center gap-2 overflow-x-auto pb-1">
                <span class="text-gray-400 dark:text-gray-500 font-medium whitespace-nowrap text-[11px] uppercase tracking-wider mr-1">Position:</span>
                <div class="flex items-center gap-1.5 flex-wrap">
                    @foreach ($positions as $pos)
                        @php
                            $isActive = $selectedPosition === $pos->value;
                        @endphp
                        <button
                            type="button"
                            wire:click="setPosition('{{ $pos->value }}')"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all flex items-center gap-1.5 {{ $isActive ? 'bg-primary-600 text-white shadow-sm ring-2 ring-primary-500/20' : 'bg-gray-50 dark:bg-gray-800/80 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/80 border border-gray-200/70 dark:border-gray-700/70' }}"
                        >
                            <span>{{ $pos->value }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Staff Members for this Position -->
            @if ($employees->isNotEmpty())
                <div class="mt-3 pt-2.5 border-t border-gray-100 dark:border-gray-800/60 flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                    <span class="text-gray-400 dark:text-gray-500 font-medium whitespace-nowrap text-[11px] uppercase tracking-wider">Staff List:</span>
                    <div class="flex items-center gap-2 flex-wrap">
                        @foreach ($employees as $emp)
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200/60 dark:border-gray-700/60">
                                <span class="w-2.5 h-2.5 rounded-full shrink-0 shadow-2xs" style="background-color: {{ $emp->color }};"></span>
                                <span class="truncate max-w-35 font-medium">{{ $emp->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-3 pt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center gap-1">
                    <x-filament::icon icon="heroicon-m-exclamation-triangle" class="w-4 h-4" />
                    <span>No employees found under <strong>{{ $selectedPosition }}</strong>. You can create employees with this position in the Employees section.</span>
                </div>
            @endif
        </div>

        <!-- ONLY THIS AREA WILL BE DOWNLOADED -->
        <div id="calendar-export-area" class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/80 dark:border-gray-800 p-5 shadow-xs space-y-4">

            <!-- Export Header -->
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center font-bold">
                        <x-filament::icon icon="heroicon-m-calendar-days" class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">
                            {{ $selectedPosition }} Work Schedule
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $startOfWeek->format('l, M d, Y') }} &ndash; {{ $endOfWeek->format('l, M d, Y') }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 dark:bg-primary-950/60 text-primary-700 dark:text-primary-300 border border-primary-200/50 dark:border-primary-800/50">
                        {{ $totalShiftsCount }} Total {{ \Illuminate\Support\Str::plural('Shift', $totalShiftsCount) }}
                    </span>
                </div>
            </div>

            <!-- 7-Day Weekly Grid -->
            <div class="grid grid-cols-1 md:grid-cols-7 gap-3">
                @foreach ($days as $day)
                    @php
                        $dayShifts = $shifts->get($day['date'], collect());
                    @endphp
                    <div class="flex flex-col min-h-110 bg-gray-50/50 dark:bg-gray-900/90 rounded-2xl border transition-all {{ $day['isToday'] ? 'border-primary-500 ring-2 ring-primary-500/20 shadow-xs' : 'border-gray-200/70 dark:border-gray-800/80' }} overflow-hidden">

                        <!-- Day Column Header -->
                        <div class="p-3 text-center border-b border-gray-100 dark:border-gray-800 {{ $day['isToday'] ? 'bg-primary-50 dark:bg-primary-950/40 text-primary-700 dark:text-primary-300' : 'bg-gray-100/60 dark:bg-gray-800/40 text-gray-800 dark:text-gray-200' }}">
                            <div class="text-[11px] uppercase tracking-wider font-bold opacity-80">{{ $day['dayName'] }}</div>
                            <div class="text-base font-black mt-0.5">{{ $day['formatted'] }}</div>
                            <div class="mt-1">
                                <span class="inline-block px-2 py-0.5 text-[10px] font-semibold rounded-full {{ $dayShifts->count() > 0 ? 'bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300' : 'bg-gray-200/70 dark:bg-gray-800 text-gray-500 dark:text-gray-400' }}">
                                    {{ $dayShifts->count() }} {{ \Illuminate\Support\Str::plural('shift', $dayShifts->count()) }}
                                </span>
                            </div>
                        </div>

                        <!-- Shifts List / Content Area -->
                        <div class="flex-1 p-2.5 space-y-2.5 overflow-y-auto">
                            @forelse ($dayShifts as $shift)
                                @php
                                    $empColor = $shift->employee?->color ?? '#3b82f6';
                                    $startCarbon = \Carbon\Carbon::parse($shift->start_time);
                                    $endCarbon = \Carbon\Carbon::parse($shift->end_time);
                                    $durationHours = round($startCarbon->diffInMinutes($endCarbon) / 60, 1);
                                @endphp
                                <div
                                    wire:click="mountAction('editShift', { shift_id: '{{ $shift->id }}' })"
                                    class="group relative rounded-xl p-3 text-white shadow-xs cursor-pointer transition-all duration-200 hover:scale-[1.02] hover:shadow-md flex flex-col justify-between"
                                    style="background-color: {{ $empColor }};"
                                >
                                    <div>
                                        <div class="flex items-start justify-between gap-1">
                                            <div class="font-bold text-xs truncate leading-tight">
                                                {{ $shift->employee?->name ?? 'Unassigned' }}
                                            </div>
                                            <span class="text-[10px] bg-black/25 px-1.5 py-0.5 rounded font-medium shrink-0">
                                                {{ $durationHours }}h
                                            </span>
                                        </div>
                                        <div class="text-[11px] font-medium opacity-95 mt-1 flex items-center gap-1">
                                            <x-filament::icon icon="heroicon-m-clock" class="w-3.5 h-3.5 shrink-0 opacity-90" />
                                            <span>{{ $startCarbon->format('g:i A') }} &ndash; {{ $endCarbon->format('g:i A') }}</span>
                                        </div>
                                    </div>

                                    @if ($shift->role_or_notes)
                                        <div class="mt-2 text-[10px] bg-black/25 backdrop-blur-xs rounded-md px-2 py-0.5 w-fit max-w-full truncate font-medium">
                                            {{ $shift->role_or_notes }}
                                        </div>
                                    @endif

                                    <div data-html2canvas-ignore="true" class="text-[9px] opacity-0 group-hover:opacity-100 transition-opacity text-right mt-1.5 font-semibold text-white/90 no-export">
                                        Click to edit &rarr;
                                    </div>
                                </div>
                            @empty
                                <div class="h-28 flex flex-col items-center justify-center text-center p-3 text-gray-400 dark:text-gray-500">
                                    <x-filament::icon icon="heroicon-o-calendar" class="w-5 h-5 mb-1 opacity-35" />
                                    <span class="text-[11px]">Free Day</span>
                                </div>
                            @endforelse
                        </div>

                        <!-- Quick Add Shift Button (Ignored in downloaded image) -->
                        <div data-html2canvas-ignore="true" class="p-2 border-t border-dashed border-gray-200/80 dark:border-gray-800 bg-white/40 dark:bg-gray-800/20 no-export">
                            <button
                                type="button"
                                wire:click="mountAction('assignShift', { date: '{{ $day['date'] }}' })"
                                class="w-full py-1.5 px-2 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-white dark:hover:bg-gray-800 rounded-lg border border-dashed border-gray-300 dark:border-gray-700 hover:border-primary-400 transition flex items-center justify-center gap-1 shadow-2xs"
                            >
                                <x-filament::icon icon="heroicon-m-plus" class="w-3.5 h-3.5" />
                                <span>Add Shift</span>
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Footer for Export View -->
            <div class="pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-[11px] text-gray-400 dark:text-gray-500">
                <span>Hotel Work Allocation &bull; Department: {{ $selectedPosition }}</span>
                <span>Week of {{ $startOfWeek->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Filament Action Modals -->
    <x-filament-actions::modals />

    <!-- Schedule Export Scripts -->
    <script src="{{ asset('js/dom-to-image.min.js') }}"></script>
    <script src="{{ asset('js/schedule-export.js') }}"></script>
</x-filament-panels::page>
