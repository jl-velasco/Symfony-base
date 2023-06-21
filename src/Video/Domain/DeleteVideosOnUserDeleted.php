<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\UserDeletedDomainEvent;

abstract class DeleteVideosOnUserDeleted implements DomainEventSubscriber
{
    public function __construct(
        private readonly VideoRepository $repository
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();

        $videos = $this->repository->findByUserId(new Uuid($data['user_id']));
        foreach ($videos as $video) {
            $this->repository->delete($video->uuid());
        }
    }

    public static function subscribedTo(): array
    {
        return [UserDeletedDomainEvent::class];
    }
}
