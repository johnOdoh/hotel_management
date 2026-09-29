<?php

namespace App\Livewire;

use App\Actions\CheckRoomAvailability;
use App\Actions\GenerateBookingReference;
use App\Enums\BookingStatus;
use App\Enums\BookingType;
use App\Mail\ReservationMail;
use App\Models\Booking;
use App\Models\RoomCategory;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
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
    public bool $paid = false;
    #[Url]
    public bool $cancelled = false;
    #[Url]
    public string $reference;

    public int $guests = 1;

    // Guest details
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $specialRequests = '';
    public string $estimatedArrival = '12:00 - 14:00';

    // Pricing & State
    public int $totalNights = 1;
    public float $basePrice = 0.0;
    public float $serviceFee = 0.0;
    public float $taxAmount = 0.0;
    public $totalPrice = 0.0;

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
        ];
    }


    public function mount(): void
    {
        if (empty($this->paid) && empty($this->cancelled)) {
            if (empty($this->checkIn)) {
                $this->checkIn = Carbon::now()->addDay()->format('Y-m-d');
            }
            if (empty($this->checkOut)) {
                $this->checkOut = Carbon::now()->addDays(3)->format('Y-m-d');
            }
            $this->calculatePricingAndAvailability();
        } else {
            if ($this->paid) $this->completeBooking();
            else $this->cancelBooking();
        }
    }

    public function updated(string $propertyName): void
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

        $rooms = app(CheckRoomAvailability::class)->handle($this->roomCategory->id, $this->checkIn, $this->checkOut);

        $availableRoom = count($rooms) > 0;

        if ($availableRoom) {
            $this->isAvailable = true;
            $this->selectedRoomId = $rooms[0]->id;
        } else {
            $this->isAvailable = false;
            $this->selectedRoomId = null;
        }
    }

    public function processBooking()
    {
        $this->validate();

        $this->calculatePricingAndAvailability();

        if (!$this->isAvailable || !$this->selectedRoomId) {
            session()->flash('error', 'Sorry, no rooms are available in this category for the selected dates. Please adjust your dates.');
            return;
        }
        $reference = app(GenerateBookingReference::class)($this->name); // Generate  $reference
        // Create booking
        $booking = Booking::create([
            'room_id' => $this->selectedRoomId,
            'reference' => $reference,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'check_in' => $this->checkIn,
            'check_out' => $this->checkOut,
            'number_of_guests' => $this->guests,
            'amount' => $this->totalPrice,
            'booking_type' => BookingType::Online,
            'status' => BookingStatus::Pending,
            'estimated_arrival_time' => $this->estimatedArrival,
            'special_request' => $this->specialRequests,
        ]);

        // Update room availability
        $response = app(PaymentService::class)->initialize($this->email, $this->totalPrice, $booking->id, $this->roomCategory->id);

        if (!$response['status']) {
            session()->flash('error', $response['message']);
            return;
        }
        return response()->redirectTo($response['message']);
    }

    private function completeBooking()
    {
        $booking = Booking::findOrFail($this->reference);
        $response = app(PaymentService::class)->verify($this->reference, $booking->amount);
        if (!$response['status']) {
            session()->flash('error', $response['message']);
            return;
        }
        $booking->status = BookingStatus::Booked;
        $booking->save();
        $this->name = $booking->name;
        $this->bookingReference = $booking->reference;
        $this->email = $booking->email;
        $this->totalPrice = $booking->amount;
        $this->checkIn = $booking->check_in;
        $this->checkOut = $booking->check_out;
        $this->roomCategory = $booking->room->category;
        $this->bookingCompleted = true;

        Mail::to($booking->email)->send(new ReservationMail($booking));
    }

    private function cancelBooking()
    {
        $booking = Booking::findOrFail($this->reference);
        $category = $booking->room->category;
        $check_in = $booking->check_in;
        $check_out = $booking->check_out;
        $booking->delete();
        $this->redirect(route('checkout', [
            'roomCategory' => $category->id,
            'checkIn' => $check_in,
            'checkOut' => $check_out
        ]), navigate: true);
    }

    public function render()
    {
        return view('livewire.hotel-checkout')
            ->title('Complete Your Reservation — ' . config('app.name') . ' Hotel & Suites');
    }
}
