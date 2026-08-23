<?php

namespace App\Livewire;

use App\Enums\BookingType;
use App\Enums\RoomStatus;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomCategory;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.guest')]
class HotelCheckout extends Component
{
    public RoomCategory $roomCategory;

    #[Url]
    public string $checkIn = '';

    #[Url]
    public string $checkOut = '';

    #[Url]
    public int $guests = 1;

    // Guest details
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $specialRequests = '';
    public string $estimatedArrival = '14:00 - 16:00';
    public string $paymentMethod = 'card';

    // Pricing & State
    public int $totalNights = 1;
    public float $basePrice = 0.0;
    public float $serviceFee = 0.0;
    public float $taxAmount = 0.0;
    public float $totalPrice = 0.0;

    public bool $isAvailable = true;
    public ?string $selectedRoomId = null;
    public bool $bookingCompleted = false;
    public ?string $bookingReference = null;
    public ?Booking $confirmedBooking = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|min:7|max:30',
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests' => 'required|integer|min:1|max:' . max(1, $this->roomCategory->capacity),
            'specialRequests' => 'nullable|string|max:500',
            'estimatedArrival' => 'nullable|string|max:50',
            'paymentMethod' => 'required|string|in:card,arrival,bank_transfer',
        ];
    }

    public function mount(RoomCategory $roomCategory): void
    {
        $this->roomCategory = $roomCategory;

        if (empty($this->checkIn)) {
            $this->checkIn = Carbon::now()->addDay()->format('Y-m-d');
        }

        if (empty($this->checkOut)) {
            $this->checkOut = Carbon::now()->addDays(3)->format('Y-m-d');
        }

        if ($this->guests < 1) {
            $this->guests = 1;
        }

        $this->calculatePricingAndAvailability();
    }

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['checkIn', 'checkOut', 'guests'])) {
            $this->calculatePricingAndAvailability();
        }
    }

    public function calculatePricingAndAvailability(): void
    {
        if (empty($this->checkIn) || empty($this->checkOut) || $this->checkIn >= $this->checkOut) {
            $this->totalNights = 1;
            $this->basePrice = (float) $this->roomCategory->amount;
            $this->serviceFee = round($this->basePrice * 0.05, 2);
            $this->taxAmount = round($this->basePrice * 0.075, 2);
            $this->totalPrice = round($this->basePrice + $this->serviceFee + $this->taxAmount, 2);
            return;
        }

        $startDate = Carbon::parse($this->checkIn);
        $endDate = Carbon::parse($this->checkOut);
        $this->totalNights = max(1, $startDate->diffInDays($endDate));

        $this->basePrice = (float) ($this->roomCategory->amount * $this->totalNights);
        $this->serviceFee = round($this->basePrice * 0.05, 2);
        $this->taxAmount = round($this->basePrice * 0.075, 2);
        $this->totalPrice = round($this->basePrice + $this->serviceFee + $this->taxAmount, 2);

        // Check if an open room is available
        $bookedRoomIds = Booking::where(function ($query) {
            $query->where('check_in', '<', $this->checkOut)
                  ->where('check_out', '>', $this->checkIn);
        })->pluck('room_id');

        $availableRoom = Room::where('room_category_id', $this->roomCategory->id)
            ->where('status', RoomStatus::Open)
            ->whereNotIn('id', $bookedRoomIds)
            ->first();

        if ($availableRoom) {
            $this->isAvailable = true;
            $this->selectedRoomId = $availableRoom->id;
        } else {
            $this->isAvailable = false;
            $this->selectedRoomId = null;
        }
    }

    public function processBooking(): void
    {
        $this->validate();

        $this->calculatePricingAndAvailability();

        if (!$this->isAvailable || !$this->selectedRoomId) {
            session()->flash('error', 'Sorry, no rooms are available in this category for the selected dates. Please adjust your dates.');
            return;
        }

        // Create booking
        $booking = Booking::create([
            'room_id' => $this->selectedRoomId,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'check_in' => $this->checkIn,
            'check_out' => $this->checkOut,
            'number_of_guests' => $this->guests,
            'amount' => $this->totalPrice,
            'booking_type' => BookingType::Online->value,
            'booked_by' => auth()->check() ? auth()->id() : null,
        ]);

        $this->confirmedBooking = $booking;
        $this->bookingReference = 'GHB-' . strtoupper(Str::random(6));
        $this->bookingCompleted = true;
    }

    public function render()
    {
        return view('livewire.hotel-checkout')
            ->title('Complete Your Reservation — Grand Horizon Hotel & Suites');
    }
}
