<?php

namespace Symfony\Base\Comment\Aplication;

use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Registation\Domain\UserDeletedDomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class DeleteCommentsOnUserDeleted implements DomainEventSubscriber
{
    public function __construct(
        private readonly CommentRepository $repository
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $this->repository->deleteByUserId(new Uuid($event->aggregateId()));
    }

    public static function subscribedTo(): array
    {
        return [UserDeletedDomainEvent::class];
    }

}