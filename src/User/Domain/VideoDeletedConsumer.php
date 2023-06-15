<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoAdded;

class VideoDeletedConsumer implements DomainEventSubscriber
{
    private const QUEUE_NAME = 'video.video_deleted.decrement';

    public function __construct(
        private readonly UserRepository $repository,
    )
    {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $this->repository->decrementVideo(new Uuid($data['user_id']));
    }

    public static function subscribedTo(): array
    {
        return [VideoAdded::class];
    }

    public static function queue(): string
    {
        return self::QUEUE_NAME;
    }
}
