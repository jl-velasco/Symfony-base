<?php

namespace Symfony\Base\VideoProyection\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoCreatedDomainEvent;
use Symfony\Base\VideoProyection\Domain\Video;
use Symfony\Base\VideoProyection\Domain\VideoRepository;

class CreateVideoOnVideoCreated implements DomainEventSubscriber
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $videoproyection = new Video(
            new Uuid($event->aggregateId()),
            new Uuid($data['user_id']),
            new Name($data['name']),
            new Description($data['description']),
            new Url($data['url'])
        );
        $this->repository->save($videoproyection);

    }

    public static function subscribedTo(): array
    {
        return [VideoCreatedDomainEvent::class];

    }
}