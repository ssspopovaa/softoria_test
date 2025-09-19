<?php

namespace App\DTO;

class PaymentDTO
{
    public function __construct(
        public readonly int $subUserId,
        public readonly int $traffic,
        public readonly string $idempotencyKey,
        public readonly string $signature,
    ) {}
}
