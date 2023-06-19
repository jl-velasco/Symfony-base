<?php

namespace Symfony\Base\Shared\Domain\Bus\Event;

interface DomainEventSubscriber
{
    public function __invoke(DomainEvent $event): void;

    /** @return string[] */
    public static function subscribedTo(): array;

    public static function queue(): string;
}