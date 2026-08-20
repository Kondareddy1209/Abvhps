<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Fast2SmsService
{
    /**
     * Fast2SMS Bulk V2 API Endpoint
     */
    protected const API_URL = 'https://www.fast2sms.com/dev/bulkV2';

    /**
     * Send OTP SMS via Fast2SMS DLT Gateway.
     *
     * @param string $phone 10-digit mobile number
     * @param string|int $otp 6-digit one-time password
     * @return array
     */
    public static function sendOtp(string $phone, $otp): array
    {
        $apiKey = config('services.fast2sms.api_key');
        $senderId = config('services.fast2sms.sender_id');
        $templateId = config('services.fast2sms.template_id');
        $entityId = config('services.fast2sms.entity_id');

        $maskedPhone = 'XXXXXX' . substr($phone, -4);

        if (empty($apiKey)) {
            Log::info("Fast2SMS: API key not configured in environment. SMS dispatch skipped for phone {$maskedPhone}.");
            return [
                'success' => true,
                'status' => 'skipped',
                'message' => 'Fast2SMS credentials not configured in environment.'
            ];
        }

        try {
            // Build payload based on DLT configuration
            if (!empty($senderId) && !empty($templateId)) {
                // DLT Route
                $payload = [
                    'route' => 'dlt',
                    'sender_id' => $senderId,
                    'message' => $templateId,
                    'variables_values' => (string) $otp,
                    'flash' => 0,
                    'numbers' => $phone,
                ];

                if (!empty($entityId)) {
                    $payload['entity_id'] = $entityId;
                }
            } else {
                // Quick OTP Route
                $payload = [
                    'route' => 'otp',
                    'variables_values' => (string) $otp,
                    'numbers' => $phone,
                    'flash' => 0,
                ];
            }

            Log::info("Fast2SMS: Initiating OTP SMS dispatch for {$maskedPhone} via " . ($payload['route'] ?? 'dlt') . " route.");

            $response = Http::timeout(10)
                ->withHeaders([
                    'authorization' => $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post(self::API_URL, $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                $returnStatus = $responseData['return'] ?? false;

                if ($returnStatus === true) {
                    Log::info("Fast2SMS: OTP SMS successfully accepted by gateway for {$maskedPhone}.");
                    return [
                        'success' => true,
                        'status' => 'sent',
                        'message' => 'SMS delivered to gateway.'
                    ];
                } else {
                    $errorMsg = $responseData['message'][0] ?? 'Fast2SMS rejected request.';
                    Log::warning("Fast2SMS Gateway Error for {$maskedPhone}: {$errorMsg}");
                    return [
                        'success' => false,
                        'status' => 'gateway_rejected',
                        'message' => $errorMsg
                    ];
                }
            }

            Log::error("Fast2SMS HTTP Error for {$maskedPhone}: Status " . $response->status());
            return [
                'success' => false,
                'status' => 'http_error',
                'message' => 'HTTP request failed with status ' . $response->status()
            ];

        } catch (\Throwable $e) {
            Log::error("Fast2SMS Exception for {$maskedPhone}: " . $e->getMessage());
            return [
                'success' => false,
                'status' => 'exception',
                'message' => 'An exception occurred during SMS dispatch.'
            ];
        }
    }
}
