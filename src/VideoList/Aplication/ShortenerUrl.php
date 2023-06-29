<?php

namespace Symfony\Base\VideoList\Aplication;

use GuzzleHttp\Client;

class ShortenerUrl
{
    private const SHORTENER_API_URI = "https://tinyurl.com/api-create.php?url=%s";
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function __invoke(string $url): string
    {
        $response = $this->client->get(sprintf(self::SHORTENER_API_URI, $url));
        return $response->getBody()->getContents();
    }
}