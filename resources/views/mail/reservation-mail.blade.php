<x-mail::message>
# Reservation Confirmed!

Dear **{{ $booking->name }}**,

Thank you for choosing **{{ config('app.name') }} Hotel & Suites**! We are thrilled to confirm your upcoming booking with us. Below are the details of your stay:

### Reservation Summary

*   **Booking Reference:** {{ $booking->reference }}
*   **Room Category:** {{ $booking->room->category->name }}
*   **Room Number:** {{ $booking->room->number }}
*   **Check-in Date:** {{ $booking->check_in->format('F j, Y') }} (From 12:00 PM)
*   **Check-out Date:** {{ $booking->check_out->format('F j, Y') }} (By 11:00 AM)
*   **Total Nights:** {{ $booking->check_in->diffInDays($booking->check_out) }} Night(s)

<x-mail::panel>
**Total Amount Paid:** NGN {{ number_format($booking->amount, 2) }}
</x-mail::panel>

### Important Information

*   Please present this email or your booking reference number upon check-in.
*   If you need to modify or cancel your booking, please contact us through any of our channels at least 48 hours prior to your check-in date.

We look forward to giving you a wonderful experience!

Warm regards, <br>
**{{ config('app.name') }} Hotel & Suites Team**

</x-mail::message>
