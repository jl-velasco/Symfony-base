<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Registater\Domain\Exceptions\UserCreatedDomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEvent;
use Symfony\Base\Shared\Domain\Bus\Event\DomainEventSubscriber;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\UserRepository;

class CreateUserOnRegisterCreated implements DomainEventSubscriber
{
    public function __construct(
        private readonly UserRepository $repository
    ) {
    }

    public function __invoke(DomainEvent $event): void
    {
        $data = $event->toPrimitives();

        $user = new User(
            new Uuid($event->aggregateId()),
            new Name($data['name'])
        );

        $this->repository->save($user);
    }

    public static function subscribedTo(): array
    {
        return [UserCreatedDomainEvent::class];
    }

    //TODO: remove coupling
    public static function queue(): string
    {
        return '';
    }
}