<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventVideoCreated;

class VideoCreatedConsumer implements DomainEventVideoCreated
{
    public function __invoke(DomainEvent $event): void
    {
        // TODO: Implement __invoke() method.
    }

    public static function videoCreatedTo(): array
    {
        return [VideoCreated::class];
    }

}
