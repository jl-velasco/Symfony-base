<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Video\Aplication\CreateVideoProyectionOnRegisterCreated;
use Symfony\Base\Video\Aplication\VideoFinder;
use Symfony\Base\VideoProyection\Domain\VideoProyection;

abstract class UpsertVideoConsumer implements DomainEventSubscriber
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly VideoFinder $finder
    )
    {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $user = $this->finder->__invoke(new Uuid($data['user_id']));
        $user->substractVideo();
        $this->repository->save($user);
    }

    public static function subscribedTo(): array
    {
        return [CreateVideoProyectionOnRegisterCreated::class];
    }
}