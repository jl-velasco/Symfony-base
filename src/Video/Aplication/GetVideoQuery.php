<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Query\Query;

class GetVideoQuery implements Query
{
    public function __construct(
        private readonly string $uuid
    )
    {
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}