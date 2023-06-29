<?php

namespace Symfony\Base\UrlShortener\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\UrlShortener\Domain\UrlShortenedRepository;
use Symfony\Base\UrlShortener\Domain\UrlShortener;
use Symfony\Base\Video\Domain\VideoCreatedDomainEvent;

class ShortenUrlOnVideoCreated implements DomainEventSubscriber
{
    private const TINYURL_API = 'https://tinyurl.com/api-create.php';

    public function __construct(
        private readonly UrlShortenedRepository $urlShortenedRepository,
        private readonly EventBus $bus
    )
    {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();

        $newUrl = $this->urlShortenedRepository->shortenUrl($data['url']);

        $urlShortener = new UrlShortener();
        $urlShortener->shortenedUrl(
            new Uuid($event->aggregateId()),
            new Uuid($data['userId']),
            new Name($data['name']),
            new Description($data['description']),
            new Url($newUrl)
        );
        $this->bus->publish(...$urlShortener->pullDomainEvents());
    }

    public static function subscribedTo(): array
    {
        return [VideoCreatedDomainEvent::class];
    }
}