<?php
declare(strict_types=1);

namespace Symfony\Base\Registation\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\Command;

class DeleteUserCommand implements Command
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