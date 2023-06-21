<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Email;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Password;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\UserRepository;

class UpsertUserUseCase
{
    public function __construct(
        private readonly UserRepository $repository
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $id,
        string $email,
        string $name,
        string $password
    ): void
    {
        $this->repository->save(
            new User(
                new Uuid($id),
                new Email($email),
                new Name($name),
                new Password($password),
            )
        );
    }

}



