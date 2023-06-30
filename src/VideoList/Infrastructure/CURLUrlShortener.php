<?php
declare(strict_types=1);

namespace Symfony\Base\VideoList\Infrastructure;

use Symfony\Base\Shared\Domain\URLRequest;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\VideoList\Domain\UrlShortener;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException;

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
        // TODO TYPE_GET, $https://tinyurl.com/api-create.php?url=
        // Mover al repositorio
        // try + catch con excepcion de dominio
        try
        {
            return new Url($this->urlRequester->request(self::TYPE_GET, new Url(self::URL_TINY . urlencode($url->value()))));
        }
        catch (Exception) {
            return false;
        }
    }
}