<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Latest News -->
            <div class="bg-white shadow rounded-lg p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Latest Announcements</h2>
                    <a href="#"
                        class="text-sm font-medium text-blue-600 hover:text-blue-800">
                        View All
                    </a>
                </div>
                @foreach ($news as $announcement)
                    <!-- News Item -->
                    <div @if(!$loop->last) class="mb-4 border-b pb-3" @endif>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-medium text-gray-800">{{ $announcement->title }}</h3>
                            <span class="px-2 py-1 text-xs rounded {{ $announcement->type->getColorClass() }}">{{ $announcement->type }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $announcement->body }}
                        </p>
                        <span class="text-xs text-gray-400 mt-2 block">{{ $announcement->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Recent Complaints -->
            <div class="bg-white shadow rounded-lg p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Recent Complaints</h2>
                    <a href="#"
                        class="text-sm font-medium text-blue-600 hover:text-blue-800">
                        View All
                    </a>
                </div>
                @foreach ($complaints as $complaint)
                    <!-- Complaint Item -->
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $complaint->subject }}</p>
                            <span class="text-xs text-gray-500">Status: {{ $complaint->status }}</span>
                        </div>
                        <span class="px-2 py-1 text-xs rounded {{ $complaint->priority->getColorClass() }}">{{ $complaint->priority }}</span>
                    </div>

                @endforeach
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
