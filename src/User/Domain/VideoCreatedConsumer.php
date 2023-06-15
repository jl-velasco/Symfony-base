<?php
declare(strict_types = 1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoCreated;

class VideoCreatedConsumer implements DomainEventSubscriber
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserFinder $finder
    )
    {
    }

    public function __invoke(DomainEvent $event): void
    {
        $user = $this->finder->__invoke(new Uuid($event->userId()));
        $user->addVideo();
        $this->repository->save($user);
    }

    public static function subscribedTo(): array
    {
        return [VideoCreated::class];
    }
}