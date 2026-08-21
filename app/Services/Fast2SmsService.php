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
        $messageId = config('services.fast2sms.message_id');
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
            // Build payload based on DLT configuration (DLT route strictly enforced)
            if (!empty($senderId) && (!empty($messageId) || !empty($templateId))) {
                // DLT Route
                $payload = [
                    'route' => 'dlt',
                    'sender_id' => $senderId,
                    'message' => (string) ($messageId ?: $templateId),
                    'dlt_content_template_id' => (string) $templateId,
                    'variables_values' => (string) $otp,
                    'numbers' => $phone,
                    'flash' => 0,
                ];

                if (!empty($entityId)) {
                    $payload['entity_id'] = $entityId;
                }
            } else {
                // Standard OTP Route
                $payload = [
                    'route' => 'otp',
                    'variables_values' => (string) $otp,
                    'numbers' => $phone,
                    'flash' => 0,
                ];
            }

            Log::info("Fast2SMS: Initiating OTP SMS dispatch for {$maskedPhone} via " . ($payload['route'] ?? 'dlt') . " route.");

            // Strict TLS/SSL verified HTTPS request (uses system CA bundle)
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
                    $errorMsg = $responseData['message'][0] ?? ($responseData['message'] ?? 'Fast2SMS rejected request.');
                    Log::warning("Fast2SMS Gateway Error for {$maskedPhone}: {$errorMsg}");
                    return [
                        'success' => false,
                        'status' => 'gateway_rejected',
                        'message' => is_array($errorMsg) ? implode(', ', $errorMsg) : (string) $errorMsg
                    ];
                }
            }

            $statusCode = $response->status();
            $responseData = $response->json();
            $responsePayload = !is_null($responseData) ? $responseData : $response->body();
            $sanitizedResponse = self::sanitizeResponse($responsePayload, $phone, (string) $otp, (string) $apiKey);

            Log::error("Fast2SMS HTTP Error for {$maskedPhone}:", [
                'status' => $statusCode,
                'response' => $sanitizedResponse,
            ]);

            return [
                'success' => false,
                'status' => 'http_error',
                'message' => 'HTTP request failed with status ' . $response->status()
            ];

        } catch (\Throwable $e) {
            $msg = self::sanitizeResponse($e->getMessage(), $phone, (string) $otp, (string) $apiKey);
            Log::error("Fast2SMS Exception for {$maskedPhone}: " . $msg);
            return [
                'success' => false,
                'status' => 'exception',
                'message' => 'An exception occurred during SMS dispatch.'
            ];
        }
    }

    /**
     * Sanitize response data before logging to ensure sensitive information is never leaked.
     *
     * @param mixed $data
     * @param string $phone
     * @param string $otp
     * @param string $apiKey
     * @return mixed
     */
    protected static function sanitizeResponse($data, string $phone, string $otp, string $apiKey)
    {
        if (is_array($data)) {
            $sanitized = [];
            foreach ($data as $key => $value) {
                if (in_array(strtolower((string) $key), ['authorization', 'api_key', 'apikey', 'secret', 'password', 'otp', 'variables_values'])) {
                    $sanitized[$key] = '***REDACTED***';
                } elseif (in_array(strtolower((string) $key), ['numbers', 'number', 'phone', 'mobile'])) {
                    $sanitized[$key] = 'XXXXXX' . substr((string) $value, -4);
                } else {
                    $sanitized[$key] = self::sanitizeResponse($value, $phone, $otp, $apiKey);
                }
            }
            return $sanitized;
        }

        if (is_string($data)) {
            if (!empty($apiKey)) {
                $data = str_replace($apiKey, '***REDACTED***', $data);
            }
            if (!empty($otp)) {
                $data = str_replace((string) $otp, '***OTP***', $data);
            }
            if (!empty($phone) && strlen($phone) >= 10) {
                $masked = 'XXXXXX' . substr($phone, -4);
                $data = str_replace($phone, $masked, $data);
            }
            return $data;
        }

        return $data;
    }
}
