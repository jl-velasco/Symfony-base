<?php

namespace Symfony\Base\UrlShortener\Domain;

use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class UrlShortener extends AggregateRoot
{
    public function shortenedUrl(
        Uuid $videoId,
        Uuid $userId,
        Name $name,
        Description $description,
        Url $url
    )
    {
        $this->record(
            new UrlShortenedDomainEvent(
                $videoId->value(),
                $userId,
                $name,
                $description,
                $url
            )
        );
    }

}