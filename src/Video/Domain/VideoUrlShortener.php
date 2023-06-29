<?php


declare(strict_types=1);

namespace Symfony\Base\Video\Domain;


use Symfony\Base\Video\Domain\Exceptions\WrongUrlException;

class VideoUrlShortener
{
    public function __construct(
        private readonly UrlShortServiceRepository $shortener,
    )
    {
    }

    /**
     * @throws WrongUrlException
     */
    public function __invoke(string $url)
    {
        $shortUrl = $this->shortener->get($url);

        if (!$shortUrl) {
            throw new  WrongUrlException($shortUrl);
        }


        return $shortUrl;

    }


}