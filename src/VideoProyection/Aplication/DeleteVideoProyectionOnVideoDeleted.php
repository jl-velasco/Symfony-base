<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Registation\Domain\UserDeletedDomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\UserRepository;
use Symfony\Base\Video\Domain\VideoDeletedDomainEvent;
use Symfony\Base\VideoProyection\Domain\VideoProyectionRepository;

class DeleteVideoProyectionOnVideoDeleted implements DomainEventSubscriber
{
    public function __construct(
        private readonly VideoProyectionRepository $repository
    )
    {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $this->repository->delete(new Uuid($data['video_id']));
    }

    public static function subscribedTo(): array
    {
        return [VideoDeletedDomainEvent::class];
    }

    //TODO: remove coupling
    public static function queue(): string
    {
        return 'user.user_deleted.delete_videos';
    }
}