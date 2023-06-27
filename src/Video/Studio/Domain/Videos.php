<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Studio\Domain;

use Symfony\Base\Shared\Domain\Collection;

class Videos extends Collection
{
    protected function type(): string
    {
        return Video::class;
    }
}