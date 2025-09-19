<?php

namespace App\Repositories;

use App\Contracts\ResellerApiClientInterface;

class ResellerApiRepository
{
    public function __construct(
        protected ResellerApiClientInterface $client
    ) {}

    public function listSubUsers(): array
    {
        return $this->client->get('/sub-user/list')->json() ?? [];
    }

    public function getSubUser(int $id): array
    {
        return $this->client->get('/sub-user/get', ['subuser_id' => $id])->json() ?? [];
    }

    public function createSubUser(array $data): array
    {
        return $this->client->post('/sub-user/create', $data)->json() ?? [];
    }

    public function updateSubUser(array $data): array
    {
        return $this->client->post('/sub-user/update', $data)->json() ?? [];
    }

    public function deleteSubUser(array $data): bool
    {
        return $this->client->post('/sub-user/delete', $data)->successful();
    }

    public function getStatistics(int $subUserId, ?string $period): array
    {
        return $this->client->get('/sub-user/usage-stat/get', [
            'subuser_id' => $subUserId,
            'period'     => $period,
        ])->json() ?? [];
    }

    public function pay(int $subUserId, int $traffic): array
    {
        return $this->client->post('/sub-user/balance/add', [
            'subuser_id' => $subUserId,
            'traffic'    => $traffic,
        ])->json() ?? [];
    }
}
