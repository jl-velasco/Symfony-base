<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Registation\Domain\UserDeletedDomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoRepository;

class DeleteVideosOnUserDeleted implements DomainEventSubscriber
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
            $video->delete();
            $this->repository->delete($video->uuid());
        }
    }

    public static function subscribedTo(): array
    {
        return [UserDeletedDomainEvent::class];
    }

    //TODO: remove coupling
    public static function queue(): string
    {
        return 'user.user_deleted.delete_videos';
    }
}