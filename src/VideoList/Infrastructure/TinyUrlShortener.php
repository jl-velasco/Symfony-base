<?php

declare(strict_types=1);

namespace Symfony\Base\VideoList\Infrastructure;

use Exception;
use Symfony\Base\Shared\Domain\Repository\Http;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\VideoList\Aplication\UrlShortener;
use Throwable;

class TinyUrlShortener implements UrlShortener
{
    const DEFAULT_DOMAIN = 'tiny.one';

    public function __construct(private readonly Http $http, private readonly string $tinyUrlApi, private readonly string $tinyUrlToken)
    {
    }

    public function __invoke(Url $url): Url
    {
        try {
            $body = [
                'url' => $url->value(),
                'domain' => self::DEFAULT_DOMAIN,
                'alias' => Uuid::random()->value(),
                'tags' => 'hexa,ddd,cqrs',
                'expires_at' => (new Date())->stringDateTime(),
            ];
            $response = $this->http->post(
                $this->tinyUrlApi,
                [
                    'Authorization' => "Bearer {$this->tinyUrlToken}",
                    'Accept' => 'application/json'
                ],
                $body
            );

            if (!empty($response['errors'])) {
                throw array_reduce($response['errors'], fn (?Exception $e, $error) => new Exception($error, 0, $e), null);
            }
        } catch (Throwable $e) {
            $rc = fopen('php://stderr', 'w');
            fwrite($rc, 'Error: ' . $e->getMessage() . PHP_EOL);
            fclose($rc);
        }

        return $url;
    }
}