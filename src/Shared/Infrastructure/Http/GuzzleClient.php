<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Http;

use GuzzleHttp\Client;
use Symfony\Base\Shared\Domain\Repository\HttpRepository;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GuzzleClient implements HttpRepository
{
    public function send(Url $url): string
    {
        $client = new Client();
        $result = $client->request('GET', $url->value());
        if ($result->getStatusCode() >= 400) {
            throw new HttpException($result->getStatusCode(), "HTTP error");
        }
        return $result->getBody()->getContents();
    }

}