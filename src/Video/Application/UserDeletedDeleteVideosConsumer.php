<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Application;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Events\UserDeletedEvent;
use Symfony\Base\Video\Domain\VideoRepository;

class UserDeletedDeleteVideosConsumer implements DomainEventSubscriber
{
    private const QUEUE_NAME = 'user.user_deleted.delete_videos';

    public function __construct(
        private readonly VideoRepository $repository
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $this->repository->deleteByUserId(new Uuid($data['user_id']));
        // Para ver los retries
        // $this->repository->deleteByUserId($data['user_id']);
    }

    public static function subscribedTo(): array
    {
        return [UserDeletedEvent::class];
    }

    public static function queue(): string
    {
        return self::QUEUE_NAME;
    }
}
