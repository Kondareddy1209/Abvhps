<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashfreePaymentService
{
    protected string $appId;
    protected string $secretKey;
    protected string $apiVersion;
    protected string $baseUrl;
    protected bool $isConfigured;

    public function __construct()
    {
        $this->appId = config('services.cashfree.app_id', '');
        $this->secretKey = config('services.cashfree.secret_key', '');
        $this->apiVersion = config('services.cashfree.api_version', '2023-08-01');
        
        $environment = config('services.cashfree.environment', 'sandbox');
        $this->baseUrl = $environment === 'production'
            ? 'https://api.cashfree.com/pg'
            : 'https://sandbox.cashfree.com/pg';

        $this->isConfigured = !empty($this->appId) && !empty($this->secretKey);
    }

    /**
     * Check if Cashfree live credentials are fully configured
     */
    public function isConfigured(): bool
    {
        return $this->isConfigured;
    }

    /**
     * Create an order on Cashfree PG Orders API
     *
     * @param string $orderId Custom order ID (e.g. ORD_MEM_123456)
     * @param float $amount Amount in INR
     * @param array $customerDetails ['customer_id', 'customer_phone', 'customer_email', 'customer_name']
     * @param string $returnUrl Post-payment redirect URL
     * @return array
     */
    public function createOrder(string $orderId, float $amount, array $customerDetails, string $returnUrl): array
    {
        if (!$this->isConfigured) {
            // Simulated response when running in local or staging environment without live credentials
            return [
                'success' => true,
                'is_simulated' => true,
                'order_id' => $orderId,
                'payment_session_id' => 'session_mock_' . strtoupper(uniqid()),
                'order_status' => 'ACTIVE',
                'message' => 'Cashfree Simulation Mode Active (Plug in App ID & Secret Key in .env when live).'
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => $this->apiVersion,
                'Content-Type' => 'application/json'
            ])->post("{$this->baseUrl}/orders", [
                'order_id' => $orderId,
                'order_amount' => $amount,
                'order_currency' => 'INR',
                'customer_details' => [
                    'customer_id' => $customerDetails['customer_id'] ?? ('CUST_' . time()),
                    'customer_name' => $customerDetails['customer_name'] ?? 'ABVHPS Devotee',
                    'customer_email' => $customerDetails['customer_email'] ?? 'support@abvhps.org',
                    'customer_phone' => $customerDetails['customer_phone'] ?? '9999999999',
                ],
                'order_meta' => [
                    'return_url' => $returnUrl . '?order_id={order_id}',
                    'notify_url' => url('/api/cashfree/webhook'),
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'is_simulated' => false,
                    'order_id' => $data['order_id'] ?? $orderId,
                    'payment_session_id' => $data['payment_session_id'] ?? null,
                    'order_status' => $data['order_status'] ?? 'ACTIVE',
                ];
            }

            Log::error('Cashfree Order Creation Failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'is_simulated' => false,
                'message' => $response->json('message') ?? 'Failed to initialize Cashfree payment gateway.'
            ];
        } catch (\Exception $e) {
            Log::error('Cashfree Service Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'is_simulated' => false,
                'message' => 'Payment gateway communication failure.'
            ];
        }
    }

    /**
     * Fetch order status from Cashfree
     */
    public function getOrderStatus(string $orderId): array
    {
        if (!$this->isConfigured) {
            return [
                'success' => true,
                'is_simulated' => true,
                'order_status' => 'PAID',
                'order_amount' => 100.00
            ];
        }

        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => $this->apiVersion,
            ])->get("{$this->baseUrl}/orders/{$orderId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return ['success' => false, 'message' => 'Failed to fetch order status'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
