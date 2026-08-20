<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Cashfree Secure ID Service
 *
 * Implements Cashfree Verification Suite (Secure ID) integration for Aadhaar
 * verification and strict server-side name matching for ABVHPS membership.
 *
 * SECURITY:
 *  - Secure ID Client ID and Secret Key stay server-side at all times.
 *  - Never log full Aadhaar numbers, OTPs, API keys, or raw personal data.
 *  - Safe failure when unconfigured (never creates fake runtime identity data).
 */
class CashfreeSecureIdService
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $baseUrl;
    protected bool $isConfigured;

    public function __construct()
    {
        $this->clientId     = (string) config('services.cashfree.verify_client_id', '');
        $this->clientSecret = (string) config('services.cashfree.verify_client_secret', '');

        $customBaseUrl = (string) config('services.cashfree.verification_base_url', '');
        if (!empty($customBaseUrl)) {
            $this->baseUrl = rtrim($customBaseUrl, '/');
        } else {
            $env = strtolower((string) config('services.cashfree.environment', 'sandbox'));
            $this->baseUrl = $env === 'production'
                ? 'https://api.cashfree.com/verification'
                : 'https://sandbox.cashfree.com/verification';
        }

        $this->isConfigured = !empty($this->clientId) && !empty($this->clientSecret);
    }

    /**
     * Check if Cashfree Secure ID credentials are configured.
     */
    public function isConfigured(): bool
    {
        return $this->isConfigured;
    }

    /**
     * Normalize a name string for identity-safe strict comparison.
     *
     * Rules:
     *  - Trim leading/trailing whitespace
     *  - Convert to uppercase (multibyte safe)
     *  - Replace punctuation (periods, commas, hyphens, underscores) with space
     *  - Collapse multiple consecutive spaces into a single space
     */
    public static function normalizeName(string $name): string
    {
        $normalized = trim($name);
        if (function_exists('mb_strtoupper')) {
            $normalized = mb_strtoupper($normalized, 'UTF-8');
        } else {
            $normalized = strtoupper($normalized);
        }

        // Replace common punctuation with a single space
        $normalized = preg_replace('/[.,\-_()\/]/', ' ', $normalized);

        // Collapse multiple whitespace characters to a single space
        $normalized = preg_replace('/\s+/', ' ', $normalized);

        return trim($normalized);
    }

    /**
     * Strict and identity-safe server-side name comparison.
     *
     * Compares user-entered name against authoritative Cashfree verified name.
     * Rejects disparate names (e.g. "KONDA REDDY" vs "RAVI KUMAR").
     * Accepts normalized exact equality and token-order permutations.
     */
    public static function compareNames(string $enteredName, string $verifiedName): bool
    {
        $normEntered  = self::normalizeName($enteredName);
        $normVerified = self::normalizeName($verifiedName);

        if (empty($normEntered) || empty($normVerified)) {
            return false;
        }

        // 1. Direct exact normalized match (e.g. "Konda Reddy" vs "KONDA REDDY")
        if ($normEntered === $normVerified) {
            return true;
        }

        // 2. Token order comparison (e.g. "Reddy Konda" vs "Konda Reddy")
        $tokensEntered  = array_filter(explode(' ', $normEntered));
        $tokensVerified = array_filter(explode(' ', $normVerified));

        if (count($tokensEntered) === count($tokensVerified)) {
            $sortedEntered  = $tokensEntered;
            $sortedVerified = $tokensVerified;
            sort($sortedEntered);
            sort($sortedVerified);

            if ($sortedEntered === $sortedVerified) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verify Aadhaar via Cashfree Secure ID Verification Suite.
     *
     * In live/sandbox environments, communicates with Cashfree Verification API.
     * If unconfigured, fails safely without producing mock identity data.
     *
     * @param string $aadhaarNumber 12-digit Aadhaar number
     * @param string $verificationId Server-controlled unique reference ID
     * @param string|null $enteredName User-entered name for optional gateway-assisted match
     * @return array Standardized result array
     */
    public function verifyAadhaar(string $aadhaarNumber, string $verificationId, ?string $enteredName = null): array
    {
        $maskedAadhaar = 'XXXX-XXXX-' . substr($aadhaarNumber, -4);

        if (!$this->isConfigured) {
            Log::warning("CashfreeSecureId: Secure ID credentials not configured in environment. Verification skipped for {$maskedAadhaar}.");
            return [
                'success' => false,
                'status'  => 'UNCONFIGURED',
                'message' => 'Cashfree Secure ID credentials are not configured. Please contact the administrator.',
            ];
        }

        try {
            // Cashfree Verification Suite: Offline Aadhaar / DigiLocker Verification Endpoint
            $endpoint = "{$this->baseUrl}/offline-aadhaar/verify";

            $payload = [
                'aadhaar_number'  => $aadhaarNumber,
                'verification_id' => $verificationId,
            ];

            if (!empty($enteredName)) {
                $payload['name'] = $enteredName;
            }

            Log::info("CashfreeSecureId: Initiating Aadhaar verification request for {$maskedAadhaar} (Ref: {$verificationId}).");

            $response = Http::withHeaders([
                'x-client-id'     => $this->clientId,
                'x-client-secret' => $this->clientSecret,
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
            ])->timeout(15)->post($endpoint, $payload);

            $statusCode = $response->status();
            $body = $response->json();

            if ($response->successful() && is_array($body)) {
                $status = strtoupper((string) ($body['status'] ?? $body['verification_status'] ?? 'SUCCESS'));

                if (in_array($status, ['SUCCESS', 'VALID', 'AUTHENTICATED', 'COMPLETED'], true)) {
                    $extracted = $this->extractIdentityData($body);
                    Log::info("CashfreeSecureId: Aadhaar verification successfully completed by gateway for {$maskedAadhaar}.");

                    return [
                        'success'         => true,
                        'status'          => $status,
                        'ref_id'          => $body['ref_id'] ?? $body['verification_id'] ?? $verificationId,
                        'verified_name'   => $extracted['name'],
                        'data'            => $extracted,
                        'message'         => 'Aadhaar identity verified successfully by Cashfree Secure ID.',
                    ];
                }

                Log::warning("CashfreeSecureId: Gateway returned non-successful verification status [{$status}] for {$maskedAadhaar}.");
                return [
                    'success' => false,
                    'status'  => $status,
                    'message' => $body['message'] ?? 'Aadhaar verification was not confirmed by the verification provider.',
                ];
            }

            Log::error("CashfreeSecureId: Gateway returned HTTP {$statusCode} for {$maskedAadhaar}.", [
                'response_message' => is_array($body) ? ($body['message'] ?? 'Unknown error') : 'Non-JSON response',
            ]);

            return [
                'success' => false,
                'status'  => 'GATEWAY_ERROR',
                'message' => is_array($body) && !empty($body['message'])
                    ? $body['message']
                    : 'Aadhaar verification failed. Please check the Aadhaar number and try again.',
            ];
        } catch (\Throwable $e) {
            Log::error("CashfreeSecureId: Network / service exception during Aadhaar verification for {$maskedAadhaar}: " . $e->getMessage());
            return [
                'success' => false,
                'status'  => 'SERVICE_EXCEPTION',
                'message' => 'Unable to communicate with the Aadhaar verification service. Please try again later.',
            ];
        }
    }

    /**
     * Standardize and extract identity fields from Cashfree verification response.
     */
    protected function extractIdentityData(array $response): array
    {
        // Check root or nested data/document blocks
        $source = $response['data'] ?? $response['document'] ?? $response;

        $name = (string) ($source['name'] ?? $source['full_name'] ?? $source['user_name'] ?? '');
        $dob  = (string) ($source['dob'] ?? $source['date_of_birth'] ?? '');

        $gender = (string) ($source['gender'] ?? '');
        if (!empty($gender)) {
            $upperGender = strtoupper(trim($gender));
            if (in_array($upperGender, ['M', 'MALE'], true)) {
                $gender = 'Male';
            } elseif (in_array($upperGender, ['F', 'FEMALE'], true)) {
                $gender = 'Female';
            } elseif (in_array($upperGender, ['O', 'OTHER'], true)) {
                $gender = 'Other';
            }
        }

        $careOf  = (string) ($source['care_of'] ?? $source['father_name'] ?? $source['father_or_husband_name'] ?? '');
        $address = (string) ($source['address'] ?? $source['permanent_address'] ?? '');

        $split = $source['split_address'] ?? [];
        $pincode  = (string) ($split['pincode'] ?? $source['pincode'] ?? $source['zip'] ?? '');
        $district = (string) ($split['district'] ?? $source['district'] ?? '');
        $state    = (string) ($split['state'] ?? $source['state'] ?? '');

        return [
            'name'                   => !empty($name) ? self::normalizeName($name) : null,
            'dob'                    => !empty($dob) ? $dob : null,
            'gender'                 => !empty($gender) ? $gender : null,
            'care_of'                => !empty($careOf) ? $careOf : null,
            'father_or_husband_name' => !empty($careOf) ? $careOf : null,
            'address'                => !empty($address) ? $address : null,
            'permanent_address'      => !empty($address) ? $address : null,
            'pincode'                => !empty($pincode) ? $pincode : null,
            'district'               => !empty($district) ? $district : null,
            'state'                  => !empty($state) ? $state : null,
            'split_address'          => [
                'pincode'  => !empty($pincode) ? $pincode : null,
                'district' => !empty($district) ? $district : null,
                'state'    => !empty($state) ? $state : null,
            ],
        ];
    }
}
