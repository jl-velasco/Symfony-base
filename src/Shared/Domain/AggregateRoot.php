<?php

namespace Symfony\Base\Shared\Domain;


class AggregateRoot
{
    private array $events = [];

    public function record(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function pullDomainEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}