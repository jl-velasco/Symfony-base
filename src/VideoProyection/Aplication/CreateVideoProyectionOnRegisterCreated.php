<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Registation\Domain\Exceptions\UserCreatedDomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\VideoCounter;
use Symfony\Base\Video\Domain\UpsertVideoConsumer;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoCreatedDomainEvent;
use Symfony\Base\VideoProyection\Domain\VideoProyectionRepository;

class CreateVideoProyectionOnRegisterCreated implements DomainEventSubscriber
{
    public function __construct(
        private readonly VideoProyectionRepository $repository
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();

        $video = new Video(
            new Uuid($event->aggregateId()),
            new Name($data['name'])
        );

        $this->repository->save($video);
    }

    public static function subscribedTo(): array
    {
        return [UpsertVideoConsumer::class];
    }

    //TODO: remove coupling
    public static function queue(): string
    {
        return '';
    }
}