<?php

declare(strict_types = 1);

namespace Symfony\Base\Registation\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Registation\Domain\Exceptions\UserNotExistException;

class UserFinder
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(Uuid $id): User
    {
        $user = $this->repository->search($id);

        if ($user === null) {
            throw new UserNotExistException((string) $id);
        }

        return $user;
    }
}
