<?php

namespace Symfony\Base\Shared\Domain;


interface DomainEventSubscriber
{
    public function __invoke(DomainEvent $event): void;

    /** @return string[] */
    public static function subscribedTo(): array;
}