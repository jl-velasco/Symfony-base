<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Video;
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

    public function __invoke(string $id): UserResponse
    {
        $user = $this->finder->__invoke(new Video($id));

        return new UserResponse(
            $user->id()->value(),
            $user->email()->value(),
            $user->name()->value()
        );
    }
}
