<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FapshiService
{
    protected string $apiKey;
    protected string $secretKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('fapshi.api_key');
        $this->secretKey = config('fapshi.secret_key');
        $this->baseUrl = config('fapshi.base_url');
    }

    protected function headers(): array
    {
        return [
            'apikey' => $this->apiKey,
            'secretkey' => $this->secretKey,
            'Content-Type' => 'application/json',
        ];
    }

    public function initiateDirectPay(float $amount, string $phone, string $reason = '', array $metadata = []): array
    {
        $payload = [
            'amount' => $amount,
            'phone' => $phone,
            'reason' => $reason ?: 'Payment',
            'type' => 'direct',
        ];

        if (!empty($metadata)) {
            $payload['metadata'] = $metadata;
        }

        $response = Http::timeout(config('fapshi.timeout', 30))
            ->withHeaders($this->headers())
            ->post($this->baseUrl . '/initiate-pay', $payload);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Fapshi direct pay failed', [
            'status' => $response->status(),
            'body' => $response->body(),
            'phone' => $phone,
            'amount' => $amount,
        ]);

        return [
            'success' => false,
            'message' => 'Payment initiation failed. Please try again.',
        ];
    }

    public function verifyTransaction(string $transactionId): array
    {
        $response = Http::timeout(config('fapshi.timeout', 30))
            ->withHeaders($this->headers())
            ->get($this->baseUrl . '/transaction-status', [
                'transId' => $transactionId,
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Fapshi transaction verification failed', [
            'status' => $response->status(),
            'body' => $response->body(),
            'transactionId' => $transactionId,
        ]);

        return [
            'success' => false,
            'status' => 'failed',
            'message' => 'Transaction verification failed.',
        ];
    }

    public function handleWebhook(array $payload): array
    {
        $transId = $payload['transId'] ?? null;
        $status = $payload['status'] ?? null;
        $amount = $payload['amount'] ?? null;
        $phone = $payload['phone'] ?? null;

        return [
            'transaction_id' => $transId,
            'status' => $status === 'SUCCESS' ? 'success' : 'failed',
            'amount' => $amount,
            'phone' => $phone,
            'reference' => $payload['message'] ?? null,
        ];
    }
}
