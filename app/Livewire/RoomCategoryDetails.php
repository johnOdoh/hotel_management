<?php

namespace App\Livewire;

use App\Enums\RoomStatus;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomCategories;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class RoomCategoryDetails extends Component
{
    public RoomCategories $roomCategory;

    public string $checkIn = '';
    public string $checkOut = '';
    public bool $searched = false;
    public bool $isAvailable = false;
    public int $availableCount = 0;
    public int $totalNights = 0;
    public string $totalPrice = '0.00';
    public ?string $errorMessage = null;

    public function mount(RoomCategories $roomCategory): void
    {
        $this->roomCategory = $roomCategory;
    }

    public function checkAvailability(): void
    {
        $this->errorMessage = null;
        $this->searched = false;

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

        // Calculate nights
        $checkInDate = Carbon::parse($this->checkIn);
        $checkOutDate = Carbon::parse($this->checkOut);
        $this->totalNights = $checkInDate->diffInDays($checkOutDate);
        $this->totalPrice = number_format($this->roomCategory->amount * $this->totalNights, 2);

        // Find rooms in this category that are open and not booked during the selected dates
        $bookedRoomIds = Booking::where(function ($query) {
            $query->where('check_in', '<', $this->checkOut)
                  ->where('check_out', '>', $this->checkIn);
        })->pluck('room_id');

        $this->availableCount = Room::where('room_category_id', $this->roomCategory->id)
            ->where('status', RoomStatus::Open)
            ->whereNotIn('id', $bookedRoomIds)
            ->count();

        $this->isAvailable = $this->availableCount > 0;
        $this->searched = true;
    }

    public function getFeatureIcon(string $feature): string
    {
        $iconMap = [
            'wifi' => 'wifi',
            'tv' => 'tv',
            'air conditioning' => 'snowflake',
            'ac' => 'snowflake',
            'mini bar' => 'wine',
            'minibar' => 'wine',
            'room service' => 'bell-concierge',
            'pool' => 'pool',
            'swimming pool' => 'pool',
            'spa' => 'spa',
            'gym' => 'dumbbell',
            'fitness' => 'dumbbell',
            'parking' => 'parking',
            'restaurant' => 'utensils',
            'laundry' => 'shirt',
            'safe' => 'lock',
            'balcony' => 'mountain-sun',
            'ocean view' => 'water',
            'sea view' => 'water',
            'city view' => 'building',
            'breakfast' => 'mug-hot',
            'coffee' => 'mug-hot',
            'bath' => 'bath',
            'bathtub' => 'bath',
            'shower' => 'shower',
            'telephone' => 'phone',
            'iron' => 'shirt',
            'hair dryer' => 'wind',
            'desk' => 'computer',
            'workspace' => 'computer',
            'kitchen' => 'kitchen-set',
            'kitchenette' => 'kitchen-set',
        ];

        $lowerFeature = strtolower($feature);
        
        foreach ($iconMap as $key => $icon) {
            if (str_contains($lowerFeature, $key)) {
                return $icon;
            }
        }

        return 'check';
    }

    public function render()
    {
        return view('livewire.room-category-details')
            ->title($this->roomCategory->name . ' — Grand Horizon Hotel & Suites');
    }
}
