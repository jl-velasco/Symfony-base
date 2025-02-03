<?php

namespace Symfony\Base\Shared\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}