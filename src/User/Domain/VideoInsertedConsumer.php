<?php

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoInserted;

class VideoInsertedConsumer implements DomainEventSubscriber
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();
        // buscamos el usuario
        $User = $this->userRepository->search(new Uuid($data['user_id']));
        // establecemos los videos en el count video
        //$this->userRepository->setCountVideo($User,count($Videos));
        $this->userRepository->increaseCountVideo($User);

    }

    public static function subscribedTo(): array
    {
        return [VideoInserted::class];
    }
}