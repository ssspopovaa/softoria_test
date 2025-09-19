<?php

namespace App\Contracts;

use Illuminate\Http\Client\Response;

interface ResellerApiClientInterface
{
    public function get(string $uri, array $params = []): Response;
    public function post(string $uri, array $data = []): Response;
}
