<?php
declare(strict_types=1);

namespace Symfony\Base\User\Application;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\User\Domain\UserRepository;

class DeleteUserUseCase
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
     * @throws InvalidValueException
     */
    public function __invoke(string $id): void
    {
        $user = $this->finder->__invoke(new Uuid($id));
        $user->delete();
        //$this->repository->delete(new Uuid($id));
        $this->bus->publish(...$user->pullDomainEvents());
    }
}
