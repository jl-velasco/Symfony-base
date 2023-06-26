<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\User\Domain\UserRepository;

class DeleteUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserFinder $finder,
        private readonly EventBus $bus
    )
    {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(DeleteUserCommand $command): void
    {
        $user = $this->finder->__invoke(new Uuid($command->id()));
        $user->delete();

        $this->repository->delete(new Uuid($command->id()));
        $this->bus->publish(...$user->pullDomainEvents());
    }
}