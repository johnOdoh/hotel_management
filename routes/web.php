<?php

use App\Livewire\HotelCheckout;
use App\Livewire\HotelLanding;
use App\Livewire\RoomCategoryDetails;
use Illuminate\Support\Facades\Route;

Route::get('/', HotelLanding::class)->name('home');
Route::get('/rooms/{roomCategory}', RoomCategoryDetails::class)->name('room.details');
Route::get('/checkout/{roomCategory}', HotelCheckout::class)->name('checkout');

Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy');
Route::view('/terms-of-service', 'pages.terms-of-service')->name('terms');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

