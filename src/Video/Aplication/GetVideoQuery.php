<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Query\Query;

class GetVideoQuery implements Query
{
    public function __construct(
    private readonly string $id
)
{
}

    public function id(): string
    {
        return $this->id;
    }
}
