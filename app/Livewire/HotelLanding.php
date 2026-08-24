<?php

namespace App\Livewire;

use App\Actions\CheckRoomAvailability;
use App\Models\RoomCategory;
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

    // Contact Form Properties
    public string $contactName = '';
    public string $contactEmail = '';
    public string $contactPhone = '';
    public string $contactSubject = 'General Inquiry';
    public string $contactMessage = '';
    public bool $contactSent = false;
    public string $contactSuccessMessage = '';

    protected function rules(): array
    {
        return [
            'contactName' => 'required|min:2|max:100',
            'contactEmail' => 'required|email|max:150',
            'contactPhone' => 'nullable|string|max:30',
            'contactSubject' => 'required|string|max:100',
            'contactMessage' => 'required|min:10|max:2000',
        ];
    }

    protected function messages(): array
    {
        return [
            'contactName.required' => 'Please provide your full name.',
            'contactEmail.required' => 'Please provide your email address.',
            'contactEmail.email' => 'Please enter a valid email address.',
            'contactSubject.required' => 'Please select or provide a subject.',
            'contactMessage.required' => 'Please write your message.',
            'contactMessage.min' => 'Your message should be at least 10 characters long.',
        ];
    }

    public function submitContactForm(): void
    {
        $this->validate();

        // Process message (e.g. log / notify / store)
        $this->contactSent = true;
        $this->contactSuccessMessage = "Thank you, {$this->contactName}! Your message regarding '{$this->contactSubject}' has been received. Our concierge team will get back to you shortly.";

        // Reset inputs
        $this->reset(['contactName', 'contactEmail', 'contactPhone', 'contactSubject', 'contactMessage']);
    }

    public function dismissContactAlert(): void
    {
        $this->contactSent = false;
        $this->contactSuccessMessage = '';
    }

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

        $category = RoomCategory::find($this->selectedCategory);

        if (!$category) {
            $this->errorMessage = 'Selected room category not found.';
            return;
        }

        $this->categoryName = $category->name;
        $this->categoryAmount = number_format($category->amount, 2);

        // Find rooms in this category that are open and not booked during the selected dates
        $room_count = app(CheckRoomAvailability::class)->handle($category->id, $this->checkIn, $this->checkOut);

        $this->availableCount = $room_count;
        $this->isAvailable = $room_count > 0;
        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.hotel-landing', [
            'categories' => RoomCategory::all(),
        ]);
    }
}