<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\Command;

class GetVideoUserCommand implements Command
{


    public function __construct(
        private readonly string $id,
    )
    {
    }

/**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}
