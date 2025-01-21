<?php

namespace Symfony\Base\Shared\Domain;

interface DomainEventSubscriber
{
    public static function subscribedTo(): array;
}