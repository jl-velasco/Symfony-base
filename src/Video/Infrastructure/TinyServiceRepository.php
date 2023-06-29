<?php


namespace Symfony\Base\Video\Infrastructure;


use http\Exception\RuntimeException;
use Symfony\Base\Video\Domain\UrlShortServiceRepository;

class TinyServiceRepository implements UrlShortServiceRepository
{

    private const URL_BASE = 'https://api.tinyurl.com/create?api_token=';


    public function __construct(
        private readonly string $config
    )
    {
    }


    public function get(string $url): string
    {
        $urlService = self::URL_BASE . $this->config;

        $ch = curl_init($urlService);
        curl_setopt($ch, CURLOPT_URL, $urlService);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
                [
                    "url" => $url,
                    "domain" => "",
                    "alias" => "",
                    "tags" => ""
                ]
            )
        );

        $response = curl_exec($ch);

        $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $responseData = json_decode($response, JSON_OBJECT_AS_ARRAY);

        if ($httpCode !== 200 || !isset($responseData['data']['tiny_url'])) {
            throw new RuntimeException('Wrong http code error (%d) %s', $httpCode, current($response['errors']));
        }

        return $responseData['data']['tiny_url'];
    }
}
