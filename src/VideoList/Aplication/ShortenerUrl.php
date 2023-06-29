<?php

namespace Symfony\Base\VideoList\Aplication;

use GuzzleHttp\Client;

class ShortenerUrl
{
    private const SHORTENER_API_URI = "https://tinyurl.com/api-create.php?url=%s";
    public function __construct() {
    }

    public function __invoke(string $url): string
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get(sprintf(self::SHORTENER_API_URI, $url));
        return $response->getBody()->getContents();
    }
}
