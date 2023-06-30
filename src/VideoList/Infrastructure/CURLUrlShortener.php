<?php
declare(strict_types=1);

namespace Symfony\Base\VideoList\Infrastructure;

use Symfony\Base\Shared\Domain\Repository\URLRequest;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\VideoList\Domain\UrlShortener;
use Symfony\Component\Config\Definition\Exception\Exception;

class CURLUrlShortener implements UrlShortener
{
    private const URL_TINY = 'https://tinyurl.com/api-create.php?url=';
    private const TYPE_GET = 'GET';

    public function __construct(
        private readonly URLRequest $urlRequester
    )
    {
    }

    public function shorten(Url $url): Url
    {
        return new Url($this->urlRequester->request(self::TYPE_GET, new Url(self::URL_TINY . urlencode($url->value()))));
    }
}