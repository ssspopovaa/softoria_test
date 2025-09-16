<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ResellerApiService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.dataimpulse.baseUrl');
        $this->token = config('services.dataimpulse.token');
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ];
    }

    public function listSubUsers(): array
    {
        $response = Http::withHeaders($this->headers())
            ->get($this->baseUrl . '/sub-user/list');

        return $response->json() ?? [];
    }

    public function getSubUser(int $id): array
    {
        $response = Http::withHeaders($this->headers())
            ->get($this->baseUrl . "/sub-user/get/?subuser_id={$id}");

        return $response->json() ?? [];
    }

    public function createSubUser(array $data): array
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/sub-user/create', $data);

        return $response->json() ?? [];
    }

    public function updateSubUser(array $data): array
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . "/sub-user/update", $data);

        return $response->json() ?? [];
    }

    public function deleteSubUser(array $data): bool
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . "/sub-user/delete", $data);

        return $response->successful();
    }

    public function getStatistics(int $subUserId, ?string $period): array
    {
        $response = Http::withHeaders($this->headers())
            ->get(
                $this->baseUrl . sprintf(
                    '/sub-user/usage-stat/get?subuser_id=%s&period=%s',
                    $subUserId,
                    $period
                )
            );

        return $response->json() ?? [];
    }

    public function simulatePayment(int $subUserId, int $traffic): array
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . "/sub-user/balance/add", [
                'subuser_id' => $subUserId,
                'traffic'    => $traffic,
            ]);

        return $response->json() ?? [];
    }
}
