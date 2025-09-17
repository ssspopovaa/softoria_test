<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ResellerApiClient
{
    protected string $baseUrl;
    protected string $token;

    public function __construct(string $baseUrl, string $token)
    {
        $this->baseUrl = $baseUrl;
        $this->token = $token;
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ];
    }

    public function get(string $uri, array $params = []): Response
    {
        return Http::withHeaders($this->headers())
            ->get($this->baseUrl . $uri, $params);
    }

    public function post(string $uri, array $data = []): Response
    {
        return Http::withHeaders($this->headers())
            ->post($this->baseUrl . $uri, $data);
    }
}
