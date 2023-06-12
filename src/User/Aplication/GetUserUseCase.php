<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Aplication\Exceptions\UserNotExistException;
use Symfony\Base\User\Domain\UserRepository;

class GetUserUseCase
{
    public function __construct(
        private readonly UserRepository $repository
    )
    {
    }

    public function __invoke(string $id): UserResponse
    {
        $user = $this->repository->search(new Uuid($id));

        if (null === $user) {
            throw new UserNotExistException($id);
        }

        return new UserResponse(
            $user->id()->value(),
            $user->email()->value(),
            $user->name()->value()
        );
    }
}