<?php

namespace App\Livewire;

use App\Enums\RoomStatus;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomCategories;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('Grand Horizon Hotel & Suites — Luxury Accommodation')]
class HotelLanding extends Component
{
    public string $selectedCategory = '';
    public string $checkIn = '';
    public string $checkOut = '';
    public bool $searched = false;
    public bool $isAvailable = false;
    public int $availableCount = 0;
    public ?string $categoryName = null;
    public ?string $categoryAmount = null;
    public ?string $errorMessage = null;

    public function checkAvailability(): void
    {
        $this->errorMessage = null;
        $this->searched = false;

        // Validation
        if (empty($this->selectedCategory)) {
            $this->errorMessage = 'Please select a room category.';
            return;
        }

        if (empty($this->checkIn) || empty($this->checkOut)) {
            $this->errorMessage = 'Please select both check-in and check-out dates.';
            return;
        }

        if ($this->checkIn >= $this->checkOut) {
            $this->errorMessage = 'Check-out date must be after check-in date.';
            return;
        }

        if ($this->checkIn < now()->format('Y-m-d')) {
            $this->errorMessage = 'Check-in date cannot be in the past.';
            return;
        }

        $category = RoomCategories::find($this->selectedCategory);

        if (!$category) {
            $this->errorMessage = 'Selected room category not found.';
            return;
        }

        $this->categoryName = $category->name;
        $this->categoryAmount = number_format($category->amount, 2);

        // Find rooms in this category that are open and not booked during the selected dates
        $bookedRoomIds = Booking::where(function ($query) {
            $query->where('check_in', '<', $this->checkOut)
                  ->where('check_out', '>', $this->checkIn);
        })->pluck('room_id');

        $this->availableCount = Room::where('room_category_id', $this->selectedCategory)
            ->where('status', RoomStatus::Open)
            ->whereNotIn('id', $bookedRoomIds)
            ->count();

        $this->isAvailable = $this->availableCount > 0;
        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.hotel-landing', [
            'categories' => RoomCategories::all(),
        ]);
    }
}
