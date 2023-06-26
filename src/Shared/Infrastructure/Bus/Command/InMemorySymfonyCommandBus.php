<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Bus\Command;

use Symfony\Base\Shared\Domain\Bus\Command\Command;
use Symfony\Base\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Base\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Base\Shared\Infrastructure\Bus\TransactionSymfonyMiddleware;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyCommandBus implements CommandBus
{
    private MessageBus $bus;

    /** @param iterable<mixed> $commandHandlers */
    public function __construct(iterable $commandHandlers, TransactionSymfonyMiddleware $transactionMiddleware)

    {
        $this->bus = new MessageBus(
            [
                $transactionMiddleware,
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forCallables($commandHandlers))
                ),
            ]
        );
    }

    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
//            throw new CommandNotRegisteredError($command);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
