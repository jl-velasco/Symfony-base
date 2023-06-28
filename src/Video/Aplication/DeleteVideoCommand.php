<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\Command;

class DeleteVideoCommand implements Command
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