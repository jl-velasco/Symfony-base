<?php

declare(strict_types = 1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Video;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;

final class UserFinder
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(Video $id): User
    {
        $user = $this->repository->search($id);

        if ($user === null) {
            throw new UserNotExistException((string) $id);
        }

        return $user;
    }
}
