<?php

namespace Symfony\Base\Shared\Infrastructure\Symfony;

use Symfony\Base\Shared\Domain\DomainEvent;
use Symfony\Base\Shared\Domain\EventBus;
use Symfony\Base\Shared\Infrastructure\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class InMemorySymfonyEventBus implements EventBus
{
    private MessageBus $bus;

    /** @param iterable<mixed> $subscribers */
    public function __construct(
        iterable $subscribers
    )
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(CallableFirstParameterExtractor::forPipedCallables($subscribers))
                ),
            ]
        );
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->bus->dispatch($event);
        }
    }
}