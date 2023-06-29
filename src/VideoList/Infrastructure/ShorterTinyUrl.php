<?php

namespace Symfony\Base\VideoList\Infrastructure;

use Symfony\Base\Shared\Domain\Repository\HttpRepository;
use Symfony\Base\Shared\Domain\ValueObject\HttpRequestType;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\VideoList\Domain\ShorterUrlRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShorterTinyUrl implements ShorterUrlRepository
{

    private const URL_SERVICE = 'https://tinyurl.com/api-create.php?url=';

    public function __construct(
        private readonly HttpRepository $httpClient
    ) {
    }

    public function shortUrl(string $url): string
    {
        $apiUrl = new Url(self::URL_SERVICE . urlencode($url));

        try {
            return $this->httpClient->send(new Url($apiUrl), new HttpRequestType('GET'));
        } catch (HttpException $e) {
            throw new \Exception('Error al acortar la URL: ' . $e->getMessage());
        };
    }
}