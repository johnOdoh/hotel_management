<?php

namespace App\Livewire;

use App\Actions\CheckRoomAvailability;
use App\Models\RoomCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
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
    public string $contactSubject = '';
    public string $contactMessage = '';
    public bool $contactSent = false;
    public string $contactSuccessMessage = '';
    public array $gallery;

    public function mount(): void
    {
        $this->gallery = [
            [
                'image' => asset('images/hotel/gallery-1.jpg'),
                'category' => 'exterior',
                'title' => 'Aerial Day View — Main Building',
                'desc' => 'A drone aerial of the hotel\'s full facade in clear daylight, showcasing its multi-storey white cladding and distinctive architectural profile.'
            ],
            [
                'image' => asset('images/hotel/gallery-2.jpg'),
                'category' => 'exterior',
                'title' => 'Illuminated Night Facade',
                'desc' => 'The glowing Tees Continental Hotel signage crowns the building at dusk, with warm amber light spilling through every floor.'
            ],
            [
                'image' => asset('images/hotel/gallery-3.jpg'),
                'category' => 'exterior',
                'title' => 'Aerial Side View — Terracotta Roof',
                'desc' => 'An elevated perspective capturing the hotel\'s distinctive terracotta roof and the surrounding lush green neighbourhood.'
            ],
            [
                'image' => asset('images/hotel/gallery-4.jpg'),
                'category' => 'exterior',
                'title' => 'Street-Level Glass Curtain Facade',
                'desc' => 'A ground-level view of the hotel\'s contemporary glass curtain wall and gated entrance, framed by a bright blue sky.'
            ],
            [
                'image' => asset('images/hotel/gallery-5.jpg'),
                'category' => 'exterior',
                'title' => 'Grand Entrance with International Flags',
                'desc' => 'The hotel\'s impressive front courtyard featuring international flag poles, a colonnaded entrance canopy, and manicured potted palms.'
            ],
            [
                'image' => asset('images/hotel/gallery-6.jpg'),
                'category' => 'exterior',
                'title' => 'Night Aerial — Warm Glow & Blue LED',
                'desc' => 'A night aerial revealing the hotel ablaze with warm golden interiors and subtle blue accent lighting across its glass atrium.'
            ],
            [
                'image' => asset('images/hotel/gallery-7.jpg'),
                'category' => 'exterior',
                'title' => 'Illuminated Night Aerial — Full Compound',
                'desc' => 'A sweeping nighttime drone shot of the entire hotel compound, showing the lit entrance, car park, and surrounding city lights.'
            ],
            [
                'image' => asset('images/hotel/gallery-8.jpg'),
                'category' => 'pool',
                'title' => 'Aerial Top-Down Pool & Deck',
                'desc' => 'A bird\'s-eye view of the freeform outdoor swimming pool flanked by rows of sun loungers and colourful floating rings.'
            ],
            [
                'image' => asset('images/hotel/gallery-9.jpg'),
                'category' => 'pool',
                'title' => 'Pool & Jacuzzi — Blue Mosaic Tiles',
                'desc' => 'The eye-catching blue mosaic-tiled pool and attached circular jacuzzi, set against the hotel\'s ornate patterned facade.'
            ],
            [
                'image' => asset('images/hotel/gallery-10.jpg'),
                'category' => 'exterior',
                'title' => 'Daytime Front View — International Flags',
                'desc' => 'A clear daytime perspective of the hotel\'s imposing front elevation with reflective glass panels, international flags, and a colonnaded ground floor.'
            ],
            [
                'image' => asset('images/hotel/gallery-11.jpg'),
                'category' => 'lobby',
                'title' => 'Reception Desk — Tees Continental Hotel',
                'desc' => 'The elegant front-desk reception featuring the hotel\'s branded marble counter, three time-zone clocks, and warm recessed lighting.'
            ],
            [
                'image' => asset('images/hotel/gallery-12.jpg'),
                'category' => 'pool',
                'title' => 'Pool Terrace with Jacuzzi & Railing',
                'desc' => 'A level view of the resort-style pool terrace complete with stainless steel railings, a circular jacuzzi, and comfortable poolside seating.'
            ],
            [
                'image' => asset('images/hotel/gallery-13.jpg'),
                'category' => 'bar',
                'title' => 'Lounge Bar — Purple Ambient Lighting',
                'desc' => 'The stylish hotel lounge bar glows with purple LED ambience, warm timber slat walls, and plush terracotta velvet seating.'
            ],
            [
                'image' => asset('images/hotel/gallery-14.jpg'),
                'category' => 'pool',
                'title' => 'Rooftop Pool — Crisp Blue Water',
                'desc' => 'A serene rooftop swimming pool with sparkling blue water, a side jacuzzi, timber deck flooring, and sun loungers ready for guests.'
            ],
            [
                'image' => asset('images/hotel/gallery-15.jpg'),
                'category' => 'exterior',
                'title' => 'Event Hall Wing & Glass Tower',
                'desc' => 'The hotel\'s expansive Event Hall wing and signature cylindrical glass tower, photographed from ground level against a dramatic sky.'
            ],
            [
                'image' => asset('images/hotel/gallery-16.jpg'),
                'category' => 'lobby',
                'title' => 'Lobby Lounge — Gold Blinds & Velvet Sofas',
                'desc' => 'A sophisticated lobby lounge space with golden zebra blinds, curved velvet sofas, a patterned feature wall, and polished marble floors.'
            ],
            [
                'image' => asset('images/hotel/gallery-17.jpg'),
                'category' => 'restaurant',
                'title' => 'Fine Dining Room — Round Table Setup',
                'desc' => 'The hotel restaurant elegantly set for dining, featuring a large round white table with gold-rim chairs and a vibrant geometric wall mural.'
            ],
            [
                'image' => asset('images/hotel/gallery-18.jpg'),
                'category' => 'lobby',
                'title' => 'Grand Lobby — Lift & Staircase',
                'desc' => 'The spacious main lobby showcasing a marble staircase, a polished lift bay, a gold luggage trolley, and sophisticated timber-panelled pillars.'
            ],
            [
                'image' => asset('images/hotel/gallery-19.jpg'),
                'category' => 'restaurant',
                'title' => 'Restaurant Dining Area — Casual Seating',
                'desc' => 'An airy dining room with neatly arranged wooden-framed chairs, white-set tables, a wall-mounted TV, and a green-accent feature wall.'
            ],
            [
                'image' => asset('images/hotel/gallery-20.jpg'),
                'category' => 'exterior',
                'title' => 'Twilight Entrance — Colonnade & Palms',
                'desc' => 'The hotel\'s colonnaded front entrance at twilight, with potted tropical palms lining the pathway and warm light welcoming guests.'
            ],
            [
                'image' => asset('images/hotel/gallery-21.jpg'),
                'category' => 'pool',
                'title' => 'Night Pool — LED Strip & Neon Lights',
                'desc' => 'A dramatic night scene of the pool ringed by warm LED strip lighting, with the pool house lit in vibrant purple and blue neon.'
            ],
        ];
    }

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
        $rooms = app(CheckRoomAvailability::class)->handle($category->id, $this->checkIn, $this->checkOut);

        $this->availableCount = count($rooms);
        $this->isAvailable = count($rooms) > 0;
        $this->searched = true;
    }


    public function render()
    {
        return view('livewire.hotel-landing', [
            'categories' => RoomCategory::all(),
        ])->title(config('app.name') . ' Hotel & Suites - Luxury Accommodation');
    }
}
