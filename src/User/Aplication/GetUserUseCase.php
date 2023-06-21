<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Base\User\Domain\UserFinder;
use Symfony\Base\User\Domain\UserRepository;

class GetUserUseCase
{
    public function __construct(
        private readonly UserFinder $finder
    )
    {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(string $id): UserResponse
    {
        $user = $this->finder->__invoke(new Uuid($id));

        return new UserResponse(
            $user->id()->value(),
            $user->email()->value(),
            $user->name()->value(),
            $user->videoCounter()->value(),
        );
    }
}
