<?php

namespace App\Livewire;

use App\Actions\CheckRoomAvailability;
use App\Models\RoomCategory;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.guest')]
class RoomCategoryDetails extends Component
{
    public RoomCategory $roomCategory;

    #[Url]
    public string $checkIn = '';

    #[Url]
    public string $checkOut = '';
    public bool $searched = false;
    public bool $isAvailable = false;
    public int $availableCount = 0;
    public int $totalNights = 0;
    public string $totalPrice = '0.00';
    public ?string $errorMessage = null;

    public function mount(): void
    {
        if (!empty($this->checkIn) && !empty($this->checkOut)) {
            $this->checkAvailability();
        }
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

        $rooms = app(CheckRoomAvailability::class)->handle($this->roomCategory->id, $this->checkIn, $this->checkOut);

        $this->availableCount = count($rooms);
        $this->isAvailable = count($rooms) > 0;
        $this->searched = true;
    }

    // public function getFeatureIcon(string $feature): string
    // {
    //     $iconMap = [
    //         'wifi' => 'wifi',
    //         'tv' => 'tv',
    //         'air conditioning' => 'snowflake',
    //         'ac' => 'snowflake',
    //         'mini bar' => 'wine',
    //         'minibar' => 'wine',
    //         'room service' => 'bell-concierge',
    //         'pool' => 'pool',
    //         'swimming pool' => 'pool',
    //         'spa' => 'spa',
    //         'gym' => 'dumbbell',
    //         'fitness' => 'dumbbell',
    //         'parking' => 'parking',
    //         'restaurant' => 'utensils',
    //         'laundry' => 'shirt',
    //         'safe' => 'lock',
    //         'balcony' => 'mountain-sun',
    //         'ocean view' => 'water',
    //         'sea view' => 'water',
    //         'city view' => 'building',
    //         'breakfast' => 'mug-hot',
    //         'coffee' => 'mug-hot',
    //         'bath' => 'bath',
    //         'bathtub' => 'bath',
    //         'shower' => 'shower',
    //         'telephone' => 'phone',
    //         'iron' => 'shirt',
    //         'hair dryer' => 'wind',
    //         'desk' => 'computer',
    //         'workspace' => 'computer',
    //         'kitchen' => 'kitchen-set',
    //         'kitchenette' => 'kitchen-set',
    //     ];

    //     $lowerFeature = strtolower($feature);

    //     foreach ($iconMap as $key => $icon) {
    //         if (str_contains($lowerFeature, $key)) {
    //             return $icon;
    //         }
    //     }

    //     return 'check';
    // }

    public function render()
    {
        return view('livewire.room-category-details')
            ->title($this->roomCategory->name . ' — ' . config('app.name') . ' Hotel & Suites');
    }
}
