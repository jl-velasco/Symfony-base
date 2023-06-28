<?php
declare(strict_types=1);

namespace Symfony\Base\Registation\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Email;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Registation\Domain\Password;
use Symfony\Base\Registation\Domain\User;
use Symfony\Base\Registation\Domain\UserRepository;

class UpsertUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly EventBus $bus
    )
    {
    }

    public function __invoke(UpsertVideoCommand $command): void
    {
        $user = User::create(
            new Uuid($command->id()),
            new Email($command->email()),
            new Name($command->name()),
            new Password($command->password()),
        );

        $this->repository->save($user);
        $this->bus->publish(...$user->pullDomainEvents());
    }
}