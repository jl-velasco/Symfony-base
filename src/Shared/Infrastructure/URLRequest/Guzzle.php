<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\URLRequest;

use Symfony\Base\Shared\Domain\Repository\URLRequest;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Infrastructure\Exceptions\HttpErrorException;

final class Guzzle implements URLRequest
{
    public function request(string $type, Url $url): string
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request($type, $url->value());

        if ($response->getStatusCode() != 200) {
            throw new HttpErrorException($url);
        };

        return $response->getBody()->getContents();
    }
}