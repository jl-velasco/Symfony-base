<?php
declare(strict_types=1);

namespace Symfony\Base\VideoProyection\Aplication;

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