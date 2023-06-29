<?php

namespace Symfony\Base\Shared\Infrastructure\URLRequest;

use Symfony\Base\Shared\Domain\ValueObject\Url;

class Guzzle
{

    function request(string $type, Url $url): string
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "https://tinyurl.com/api-create.php?url=" . urlencode($url->value()));

        if( $response->getStatusCode()!= 200) {
            //thorw algo
        };
        $responseType = $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
        return $response->getBody()->getContents();
    }
}