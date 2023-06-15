<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\ValueObject\Video;
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

    public function __invoke(string $id): void
    {
        $user = $this->finder->__invoke(new Video($id));
        $user->delete();
        $this->repository->delete(new Video($id));
        $this->bus->publish(...$user->pullDomainEvents());
    }
}
