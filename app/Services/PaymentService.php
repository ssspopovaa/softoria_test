<?php

namespace App\Services;

use App\DTO\PaymentDTO;
use App\Repositories\ResellerApiRepository;
use App\Support\SignatureGenerator;
use Illuminate\Support\Facades\Cache;

class PaymentService
{
    public function __construct(
        protected ResellerApiRepository $repository
    ) {}

    public function process(PaymentDTO $payment): string
    {
        $expectedSignature = SignatureGenerator::generate(
            $payment->subUserId,
            $payment->idempotencyKey,
            config('services.dataimpulse.webhook_secret')
        );

        if (!hash_equals($expectedSignature, $payment->signature)) {
            return 'Invalid signature';
        }

        if (Cache::has('payment_' . $payment->idempotencyKey)) {
            return 'Payment already processed';
        }

        $this->repository->pay($payment->subUserId, $payment->traffic);

        Cache::put('payment_' . $payment->idempotencyKey, true, now()->addHour());

        return 'Payment processed successfully!';
    }
}
