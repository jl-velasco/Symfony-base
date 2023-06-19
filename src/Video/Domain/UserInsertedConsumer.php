<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\UserInserted;

abstract class UserInsertedConsumer implements DomainEventSubscriber
{
    public function __construct(
        private VideoRepository $repository
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $this->repository->save(new Uuid($data['user_id']));
    }

    public static function subscribedTo(): array
    {
        return [UserInserted::class];
    }
}