<?php


declare(strict_types=1);

namespace Symfony\Base\Video\Domain;


class VideoUrlShortener
{
    public function __construct(
        private readonly UrlShortServiceRepository $shortener,
    )
    {
    }

    public function __invoke(string $url)
    {
        $shortUrl = $this->shortener->get($url);


//            if(!$shortUrl)
//            {
//                throw new  WrongUrlException($shortUrl);
//            }


        return $shortUrl;

    }


}