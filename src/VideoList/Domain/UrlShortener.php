<?php

namespace Symfony\Base\VideoList\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\VideoList\Domain\Exceptions\VideoNotFoundException;

interface UrlShortener
{
    function shorten(Url $url): Url;
}