<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventVideoDeleted;

class VideoDeletedConsumer implements DomainEventVideoDeleted
{
public function __invoke(DomainEvent $event): void
{
    // TODO: Implement __invoke() method.
}
public static function videoDeletedTo():array{
    return [VideoDeleted::class];
}

}
