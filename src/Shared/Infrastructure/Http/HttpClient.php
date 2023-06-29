<?php

namespace Symfony\Base\Shared\Infrastructure\Http;

use Symfony\Base\Shared\Domain\Repository\Http;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClient implements Http
{
    public function __construct(
        private readonly HttpClientInterface $httpClient
    )
    {
    }

    public function get(string $url, ?array $params = []): string
    {
        $response = $this->httpClient->request(
            'GET',
            $url,
            [
                'query' => $params
            ]
        );

        $content = $response->getContent();
        return $content;
    }
}