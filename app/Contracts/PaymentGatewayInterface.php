<?php

namespace App\Contracts;

use App\Models\Donation;
use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    /**
     * Create an order on the payment gateway
     *
     * @param Donation $donation
     * @param string $returnUrl
     * @return array ['success' => bool, 'order_id' => string, 'session_data' => array, 'message' => ?string]
     */
    public function createOrder(Donation $donation, string $returnUrl): array;

    /**
     * Verify payment status/signature from client response
     *
     * @param Request $request
     * @param Donation $donation
     * @return array ['success' => bool, 'payment_id' => ?string, 'reference' => ?string, 'status' => string, 'message' => ?string]
     */
    public function verifyPayment(Request $request, Donation $donation): array;

    /**
     * Verify authenticity of webhook signature
     *
     * @param Request $request
     * @return bool
     */
    public function verifyWebhookSignature(Request $request): bool;

    /**
     * Process webhook payload
     *
     * @param Request $request
     * @return array ['success' => bool, 'gateway_order_id' => ?string, 'payment_id' => ?string, 'reference' => ?string, 'status' => string]
     */
    public function handleWebhook(Request $request): array;

    /**
     * Get real-time status of an order from gateway
     *
     * @param string $gatewayOrderId
     * @return array
     */
    public function getPaymentStatus(string $gatewayOrderId): array;
}
