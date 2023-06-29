<?php

namespace Symfony\Base\VideoList\Infrastructure;

use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\Infrastructure\Http\GuzzleClient;
use Symfony\Base\VideoList\Domain\ShorterUrlRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShorterTinyUrl implements ShorterUrlRepository, HttpRepository
{

    private const URL_SERVICE = 'https://tinyurl.com/api-create.php?url=';

    public function __construct(
        private readonly GuzzleClient $client
    ) {
    }

    public function shortUrl(string $url): string
    {
        $apiUrl = new Url(self::URL_SERVICE . urlencode($url));
        $urlShort = '';

        try {
            return $this->httpClient->send(new Url($apiUrl));
        } catch (HttpException $e) {
            throw new \Exception('Error al acortar la URL: ' . $e->getMessage());
        };
    }
}