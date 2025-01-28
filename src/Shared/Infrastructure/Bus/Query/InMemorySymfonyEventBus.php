<?php

namespace Symfony\Base\Shared\Infrastructure\Bus\Query;

use Symfony\Base\Shared\Domain\Bus\Response;
use Symfony\Base\Shared\Domain\Bus\Query;
use Symfony\Base\Shared\Domain\Bus\QueryBus;
use Symfony\Base\Shared\Infrastructure\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyEventBus implements QueryBus
{
    private MessageBus $bus;

    /** @param iterable<mixed> $queryHandler */
    public function __construct(
        iterable $queryHandler
    )
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forPipedCallables($queryHandler))
                ),
            ]
        );
    }

    public function ask(Query $query): Response
    {
        $this->bus->dispatch($query);
    }
}