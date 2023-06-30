<?php

namespace Symfony\Base\VideoList\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoCreatedDomainEvent;
use Symfony\Base\VideoList\Domain\Video;
use Symfony\Base\VideoList\Domain\VideoRepository;

class CreateVideoListOnVideoCreated implements DomainEventSubscriber
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly UrlShortener $urlShortener
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();

        $video = new Video(
            new Uuid($event->aggregateId()),
            new Uuid($data['user_id']),
            new Name($data['name']),
            new Description($data['description']),
            $this->urlShortener->__invoke(new Url($data['url'])),
        );

        $this->repository->save($video);
    }

    public static function subscribedTo(): array
    {
        return [VideoCreatedDomainEvent::class];
    }

    //TODO: remove coupling
    public static function queue(): string
    {
        return '';
    }
}