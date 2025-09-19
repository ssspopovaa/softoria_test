<?php

namespace App\Services;

use App\Repositories\ResellerApiRepository;

class SubUserService
{
    public function __construct(
        protected ResellerApiRepository $repository
    ) {}

    public function list(): array
    {
        return $this->repository->listSubUsers()['subusers'] ?? [];
    }

    public function get(int $id): array
    {
        return $this->repository->getSubUser($id);
    }

    public function create(array $data): array
    {
        return $this->repository->createSubUser($data);
    }

    public function update(array $data): array
    {
        return $this->repository->updateSubUser($data);
    }

    public function delete(array $data): bool
    {
        return $this->repository->deleteSubUser($data);
    }

    public function statistics(int $subUserId, string $period): array
    {
        return $this->repository->getStatistics($subUserId, $period);
    }
}
