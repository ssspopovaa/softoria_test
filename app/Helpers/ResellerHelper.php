<?php

namespace App\Helpers;

class ResellerHelper
{
    public static function generateIdempotencyKey(): string
    {
        return bin2hex(random_bytes(16));
    }

    public static function generateSignature(int $subUserId, string $idempotencyKey): string
    {
        $payload = json_encode([
            'subuser_id' => $subUserId,
            'idempotency_key' => $idempotencyKey,
        ]);

        $secret = config('services.dataimpulse.webhook_secret');

        return hash_hmac('sha256', $payload, $secret);
    }
}
