<?php

namespace Symfony\Base\Video\Video\Application;

use Symfony\Base\Shared\Domain\Bus\Command\Command;

class UpdateVideoCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $name,
        public readonly string $description,
        public readonly string $url,
    )
    {
    }
}