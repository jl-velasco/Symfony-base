<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\URLRequest;

use Symfony\Base\Shared\Domain\URLRequest;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Infrastructure\Exceptions\HttpErrorException;

final class Guzzle implements URLRequest
{
    public function request(string $type, Url $url): string
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request($type, $url->value());

        if ($response->getStatusCode() != 200) {
            //thorw algo, comentar si es correcto
            // cambiar el nombre de la clase a HttpErrorExcepcion
            throw new HttpErrorException($url);
        };

        return $response->getBody()->getContents();
    }
}