<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentService
{
    public string $secret;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->secret = env('PAYSTACK_SECRET');
    }

    public function initialize(string $email, float $amount, string $reference, string $room_category_id): array
    {
        try {
            $url = 'https://api.paystack.co/transaction/initialize';
            $transaction = Http::withToken($this->secret)->post($url, [
                'email' => $email,
                'amount' => $amount * 100,
                'callback_url' => route('checkout', ['roomCategory' => $room_category_id, 'paid' => true]),
                'reference' => $reference,
                'metadata' => [
                    'cancel_action' => route('checkout', ['roomCategory' => $room_category_id, 'cancelled' => true, 'reference' => $reference]),
                ]
            ]);
            $response = $transaction->json();
            if ($transaction->successful()) {
                return [
                    'status' => true,
                    'message' => $response['data']['authorization_url']
                ];
            }
            return [
                'status' => false,
                'message' => $response['message']
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage()
            ];
        }
    }

    public function verify(string $reference, $amount): array
    {
        try {
            $url = 'https://api.paystack.co/transaction/verify/' . $reference;
            $transaction = Http::withToken($this->secret)->get($url);
            $response = $transaction->json();
            if ($transaction->successful()) {
                if ($response['data']['status'] != 'success' || $response['data']['amount'] != $amount * 100) {
                    return [
                        'status' => false,
                        'message' => 'Payment verification failed. Please try again. If you have been charged, please contact support.'
                    ];
                }
                return [
                    'status' => true,
                    'data' => null
                ];
            }
            return [
                'status' => false,
                'message' => $response['message']
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}
