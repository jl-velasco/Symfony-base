<?php

namespace Symfony\Base\VideoList\Infrastructure;

use Doctrine\DBAL\Exception;
use MongoDB\Collection;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\Repository\Mongo;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Infrastructure\Exceptions\PersistenceLayerException;
use Symfony\Base\Shared\Infrastructure\Mongo\MongoDBDocumentConverter;
use Symfony\Base\Shared\Infrastructure\URLRequest\Guzzle;
use Symfony\Base\VideoList\Domain\UrlShortener;
use Symfony\Base\VideoList\Domain\Video;
use Symfony\Base\VideoList\Domain\VideoRepository;
use Symfony\Base\VideoList\Domain\Videos;

class CURLUrlShortener implements UrlShortener
{

    public function __construct(
        private readonly Guzzle $urlRequester
    )
    {
    }

    function shorten(Url $url): Url
    {
        //return new Url("http://douglas.es/api/zonasegura");   // TODO: Implement shorten() method.;
        return new Url($this->urlRequester->request('GET',$url));   // TODO: Implement shorten() method.;
    }
}