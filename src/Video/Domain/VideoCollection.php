<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Collection;

class VideoCollection extends Collection
{
    protected function type(): string
    {
        return Video::class;
    }

}
