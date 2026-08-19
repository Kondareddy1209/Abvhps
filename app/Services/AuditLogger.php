<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Keys that must never be recorded in audit logs.
     */
    protected static array $sensitiveKeys = [
        'password',
        'password_confirmation',
        'plainPassword',
        'token',
        'remember_token',
        'secret',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'api_key',
        'key',
        'card',
        'cvv',
    ];

    /**
     * Log a security or administrative action.
     */
    public static function log(
        string $action,
        ?string $targetType = null,
        ?string $targetId = null,
        array $metadata = [],
        ?string $actorType = null,
        ?string $actorIdentifier = null,
        ?int $actorId = null
    ): AuditLog {
        // Resolve Actor if not explicitly supplied
        if ($actorId === null && $actorIdentifier === null) {
            if (auth('web')->check()) {
                $user = auth('web')->user();
                $actorType = $actorType ?? 'Admin';
                $actorId = $user->id;
                $actorIdentifier = $user->email;
            } elseif (auth('volunteer')->check()) {
                $vol = auth('volunteer')->user();
                $actorType = $actorType ?? 'Volunteer';
                $actorId = $vol->id;
                $actorIdentifier = $vol->volunteer_id ?? $vol->volunteer_login_id;
            } else {
                $actorType = $actorType ?? 'Anonymous';
            }
        }

        // Sanitize metadata to strip any sensitive values
        $safeMetadata = self::sanitizeMetadata($metadata);

        return AuditLog::create([
            'actor_id' => $actorId,
            'actor_type' => $actorType,
            'actor_identifier' => $actorIdentifier,
            'action' => strtoupper($action),
            'target_type' => $targetType,
            'target_id' => $targetId,
            'ip_address' => Request::ip() ?? '127.0.0.1',
            'user_agent' => substr(Request::userAgent() ?? 'System', 0, 500),
            'metadata' => $safeMetadata,
            'created_at' => now(),
        ]);
    }

    /**
     * Recursively sanitize metadata array.
     */
    protected static function sanitizeMetadata(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (in_array(strtolower((string)$key), self::$sensitiveKeys, true)) {
                $sanitized[$key] = '[REDACTED]';
            } elseif (is_array($value)) {
                $sanitized[$key] = self::sanitizeMetadata($value);
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }
}
