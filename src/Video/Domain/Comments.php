<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Collection;

class Comments extends Collection
{
    protected function type(): string
    {
        return Comment::class;
    }
}