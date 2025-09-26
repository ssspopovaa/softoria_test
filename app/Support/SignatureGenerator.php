<?php

namespace App\Support;

class SignatureGenerator
{
    public static function generate(int $subUserId, string $idempotencyKey, string $secret): string
    {
        $data = json_encode([
            'subuser_id'     => $subUserId,
            'idempotency_key'=> $idempotencyKey,
        ]);

        return hash_hmac('sha256', $data, $secret);
    }
}
