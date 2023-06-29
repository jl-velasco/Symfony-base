<?php


namespace Symfony\Base\Video\Infrastructure;


use Symfony\Base\Video\Domain\UrlShortServiceRepository;

class TinyServiceRepository implements UrlShortServiceRepository
{

    private const URL_BASE = 'https://api.tinyurl.com/create';


    public function __construct(
        private readonly string $config
    )
    {
    }


    public function get(string $url): string
    {
        if (!$this->config) {

            //@todo exception
        }
        $urlService = self::URL_BASE . '?' . $this->config;

        $ch = curl_init($urlService);
        curl_setopt($ch, CURLOPT_URL, $urlService);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            "url" => $url,
            "domain" => "",//@todo move to config
            "alias" => "",
            "tags" => "",
//            "expires_at" => (new \DateTime())->add(new \DateInterval("P2D"))->format('Y-m-d H:i:s')

        )));

        $response = curl_exec($ch);

        $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode !== 200) {
            //@todo exception
        }

        $responseData = json_decode($response, JSON_OBJECT_AS_ARRAY);
        //@todo check json fields
        return $responseData['data']['tiny_url'];

    }
}
