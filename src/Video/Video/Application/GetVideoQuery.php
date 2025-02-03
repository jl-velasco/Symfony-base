<?php

namespace Symfony\Base\Video\Video\Application;

use Symfony\Base\Shared\Domain\Bus\Query\Query;

class GetVideoQuery implements Query
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}