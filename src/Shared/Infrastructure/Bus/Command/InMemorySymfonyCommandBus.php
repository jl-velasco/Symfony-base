<?php

namespace Symfony\Base\Shared\Infrastructure\Bus\Command;

use Symfony\Base\Shared\Domain\Bus\Command\Command;
use Symfony\Base\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Base\Shared\Infrastructure\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyCommandBus implements CommandBus
{
    private MessageBus $bus;

    /** @param iterable<mixed> $commandHandlers */
    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forCallables($commandHandlers))
                ),
            ]
        );
    }

    public function dispatch(Command $command): void
    {
        $this->bus->dispatch($command);
    }
}