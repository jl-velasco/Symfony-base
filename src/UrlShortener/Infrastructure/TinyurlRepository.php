<?php

namespace Symfony\Base\UrlShortener\Infrastructure;

use Symfony\Base\Shared\Domain\Repository\Http;
use Symfony\Base\UrlShortener\Domain\UrlShortenedRepository;

class TinyurlRepository implements UrlShortenedRepository
{
    private const TINYURL_API = 'https://tinyurl.com/api-create.php';

    public function __construct(
        private readonly Http $httpClient
    )
    {
    }

    public function shortenUrl(string $url): string
    {
        $params = [
            'url' => $url
        ];

        return $this->httpClient->get(self::TINYURL_API, $params);
    }
}