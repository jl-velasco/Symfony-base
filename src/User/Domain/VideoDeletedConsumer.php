<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Video\Domain\VideoAdded;

class VideoDeletedConsumer implements DomainEventSubscriber
{
    public function __invoke(DomainEvent $event): void
    {
        $connection = null;

        //TODO: Recibimos el evento cuando tengamos un nuevo video
    }

    public static function subscribedTo(): array
    {
        return [VideoAdded::class];
    }
}
