<?php

namespace Symfony\Base\VideoList\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoDeletedDomainEvent;
use Symfony\Base\VideoList\Domain\Video;
use Symfony\Base\VideoList\Domain\VideoRepository;

class DeleteVideoListOnVideoDeleted implements DomainEventSubscriber
{
    public function __construct(
        private readonly VideoRepository $repository
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $this->repository->delete(new Uuid($event->aggregateId()));
    }

    public static function subscribedTo(): array
    {
        return [VideoDeletedDomainEvent::class];
    }

    //TODO: remove coupling
    public static function queue(): string
    {
        return '';
    }
}