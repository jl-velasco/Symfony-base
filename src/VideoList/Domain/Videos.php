<?php

namespace Symfony\Base\VideoList\Domain;

use Symfony\Base\Shared\Domain\Collection;

class Videos extends Collection
{
    protected function type(): string
    {
        return Video::class;
    }
}