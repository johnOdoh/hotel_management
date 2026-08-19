<?php

namespace Database\Seeders;

use App\Enums\BookingType;
use App\Enums\RoomStatus;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomCategories;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Presidential Penthouse Suite
        $presidential = RoomCategories::updateOrCreate(
            ['name' => 'Presidential Penthouse Suite'],
            [
                'images' => [
                    'rooms/presidential_1.jpg',
                    'rooms/presidential_2.jpg',
                ],
                'features' => [
                    'High-Speed WiFi',
                    'Private Jacuzzi',
                    'Ocean & City View',
                    'King Size Bed',
                    'Mini Bar & Wine Cellar',
                    '24/7 Room Service',
                    'Smart TV 75"',
                    'Balcony & Terrace',
                    'Luxury Bath & Shower',
                    'Espresso Machine',
                ],
                'description' => 'The pinnacle of opulence and luxury. Our Presidential Penthouse Suite spans 120 square meters of exquisitely designed living space featuring a private heated indoor jacuzzi overlooking panoramic skyline views, a master bedroom with an ultra-plush king bed, separate living and dining areas, a private terrace, and 24/7 personalized butler service.',
                'amount' => 850.00,
                'capacity' => 4,
                'size' => 120.0,
            ]
        );

        // 2. Deluxe Ocean Suite
        $deluxe = RoomCategories::updateOrCreate(
            ['name' => 'Deluxe Ocean Suite'],
            [
                'images' => [
                    'rooms/deluxe_1.jpg',
                    'rooms/deluxe_2.jpg',
                ],
                'features' => [
                    'High-Speed WiFi',
                    'Ocean View',
                    'Balcony & Sun Lounger',
                    'King Size Bed',
                    'Air Conditioning',
                    'Room Service',
                    'Smart TV 55"',
                    'Mini Bar',
                    'Bathtub & Rain Shower',
                    'In-Room Safe',
                ],
                'description' => 'Awaken to breathtaking sunrise views over turquoise waters in our Deluxe Ocean Suite. Designed with floor-to-ceiling windows, a private furnished balcony, marble bathroom with a deep soaking tub and rain shower, and a plush king bed tailored for restorative rest.',
                'amount' => 420.00,
                'capacity' => 3,
                'size' => 65.0,
            ]
        );

        // 3. Executive Business King
        $executive = RoomCategories::updateOrCreate(
            ['name' => 'Executive Business King'],
            [
                'images' => [
                    'rooms/executive_1.jpg',
                    'rooms/executive_2.jpg',
                ],
                'features' => [
                    'High-Speed WiFi',
                    'Dedicated Workspace',
                    'City View',
                    'King Size Bed',
                    'Air Conditioning',
                    'Espresso Coffee Machine',
                    'Smart TV 50"',
                    'Mini Bar',
                    'Walk-in Shower',
                    'Iron & Ironing Board',
                ],
                'description' => 'Tailored for the modern corporate traveler and discerning guests, the Executive Business King combines sophistication with functional luxury. Features an ergonomic executive workspace, high-speed fiber internet, premium espresso machine, and floor-to-ceiling city views.',
                'amount' => 280.00,
                'capacity' => 2,
                'size' => 48.0,
            ]
        );

        // 4. Superior Premier Room
        $superior = RoomCategories::updateOrCreate(
            ['name' => 'Superior Premier Room'],
            [
                'images' => [
                    'rooms/deluxe_2.jpg',
                    'rooms/executive_1.jpg',
                ],
                'features' => [
                    'High-Speed WiFi',
                    'Queen Size Bed',
                    'Air Conditioning',
                    'Smart TV 43"',
                    'Mini Bar',
                    'Rain Shower',
                    'Coffee & Tea Maker',
                    'In-Room Safe',
                ],
                'description' => 'A warm and inviting sanctuary blending contemporary style with essential comforts. Our Superior Premier Room offers premium bedding, a state-of-the-art entertainment system, spa-inspired walk-in rain shower, and quiet ambient lighting.',
                'amount' => 180.00,
                'capacity' => 2,
                'size' => 38.0,
            ]
        );

        // Seed Rooms for Presidential
        $presidentialRooms = [
            ['number' => 'PH-501', 'status' => RoomStatus::Open],
            ['number' => 'PH-502', 'status' => RoomStatus::Open],
        ];

        foreach ($presidentialRooms as $roomData) {
            Room::updateOrCreate(
                ['number' => $roomData['number']],
                [
                    'room_category_id' => $presidential->id,
                    'status' => $roomData['status'],
                ]
            );
        }

        // Seed Rooms for Deluxe Ocean Suite
        $deluxeRooms = [
            ['number' => 'OS-301', 'status' => RoomStatus::Open],
            ['number' => 'OS-302', 'status' => RoomStatus::Open],
            ['number' => 'OS-303', 'status' => RoomStatus::Open],
            ['number' => 'OS-304', 'status' => RoomStatus::Locked],
        ];

        foreach ($deluxeRooms as $roomData) {
            Room::updateOrCreate(
                ['number' => $roomData['number']],
                [
                    'room_category_id' => $deluxe->id,
                    'status' => $roomData['status'],
                ]
            );
        }

        // Seed Rooms for Executive Business King
        $executiveRooms = [
            ['number' => 'EX-201', 'status' => RoomStatus::Open],
            ['number' => 'EX-202', 'status' => RoomStatus::Open],
            ['number' => 'EX-203', 'status' => RoomStatus::Open],
            ['number' => 'EX-204', 'status' => RoomStatus::UnderMaintenance],
            ['number' => 'EX-205', 'status' => RoomStatus::Open],
        ];

        foreach ($executiveRooms as $roomData) {
            Room::updateOrCreate(
                ['number' => $roomData['number']],
                [
                    'room_category_id' => $executive->id,
                    'status' => $roomData['status'],
                ]
            );
        }

        // Seed Rooms for Superior Premier Room
        $superiorRooms = [
            ['number' => 'SP-101', 'status' => RoomStatus::Open],
            ['number' => 'SP-102', 'status' => RoomStatus::Open],
            ['number' => 'SP-103', 'status' => RoomStatus::Open],
            ['number' => 'SP-104', 'status' => RoomStatus::Open],
            ['number' => 'SP-105', 'status' => RoomStatus::Open],
            ['number' => 'SP-106', 'status' => RoomStatus::Locked],
        ];

        foreach ($superiorRooms as $roomData) {
            Room::updateOrCreate(
                ['number' => $roomData['number']],
                [
                    'room_category_id' => $superior->id,
                    'status' => $roomData['status'],
                ]
            );
        }

        // Create sample booking for testing availability overlap
        $sampleRoom = Room::where('number', 'PH-501')->first();
        if ($sampleRoom) {
            Booking::updateOrCreate(
                [
                    'room_id' => $sampleRoom->id,
                    'check_in' => Carbon::now()->addDays(2)->format('Y-m-d'),
                ],
                [
                    'name' => 'Alexander Wright',
                    'email' => 'alexander.wright@example.com',
                    'phone' => '+1 (555) 234-5678',
                    'check_out' => Carbon::now()->addDays(5)->format('Y-m-d'),
                    'number_of_guests' => 2,
                    'amount' => 2550.00,
                    'booking_type' => BookingType::Online->value,
                ]
            );
        }

        $sampleRoom2 = Room::where('number', 'PH-502')->first();
        if ($sampleRoom2) {
            Booking::updateOrCreate(
                [
                    'room_id' => $sampleRoom2->id,
                    'check_in' => Carbon::now()->addDays(2)->format('Y-m-d'),
                ],
                [
                    'name' => 'Eleanor Vance',
                    'email' => 'eleanor.vance@example.com',
                    'phone' => '+1 (555) 876-5432',
                    'check_out' => Carbon::now()->addDays(5)->format('Y-m-d'),
                    'number_of_guests' => 3,
                    'amount' => 2550.00,
                    'booking_type' => BookingType::Online->value,
                ]
            );
        }
    }
}
