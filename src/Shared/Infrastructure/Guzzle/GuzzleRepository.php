<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Symfony\Base\Shared\Domain\Repository\Http;

class GuzzleRepository implements Http
{
    /**
     * @throws JsonException|GuzzleException
     */
    public function post(string $url, array $headers = [], array $body = []): array
    {
        $client = new Client();
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $body
        ]);
        return json_decode(
            json: $response->getBody()->getContents(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
    }

}