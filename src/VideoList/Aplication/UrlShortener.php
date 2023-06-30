<?php

declare(strict_types=1);

namespace Symfony\Base\VideoList\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Url;

interface UrlShortener
{
    public function __invoke(Url $url): Url;
}