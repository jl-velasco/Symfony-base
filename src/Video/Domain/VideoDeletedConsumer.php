<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;

class VideoDeletedConsumer implements DomainEventSubscriber
{
    public function __invoke(DomainEvent $event): void
    {
        $a=0;
        //TODO: Caso de uso para eliminar los videos de un usuario
    }

    public static function subscribedTo(): array
    {
        return [VideoDeleted::class];
    }
}