<?php

namespace App\DTO;

class SubUserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $label,
        public readonly int $threads,
    ) {}
}
