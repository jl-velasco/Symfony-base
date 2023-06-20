<?php
declare(strict_types=1);

namespace Symfony\Base\User\Application;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Base\User\Domain\UserFinder;


class GetUserUseCase
{
    public function __construct(
        private readonly UserFinder $finder
    )
    {
    }

    /**
     * @throws UserNotExistException
     * @throws InvalidValueException
     */
    public function __invoke(string $id): UserResponse
    {
        $user = $this->finder->__invoke(new Uuid($id));

        return new UserResponse($user);
    }
}
