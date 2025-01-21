<?php

namespace Symfony\Base\Shared\Domain;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}