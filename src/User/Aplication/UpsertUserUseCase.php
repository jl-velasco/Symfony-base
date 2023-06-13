<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Email;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\User\Aplication\Exceptions\DuplicateUserException;
use Symfony\Base\User\Dominio\Exceptions\PasswordIncorrectException;
use Symfony\Base\User\Dominio\Password;
use Symfony\Base\User\Dominio\User;
use Symfony\Base\User\Dominio\UserRepository;

class UpsertUserUseCase
{
    public function __construct(
        private readonly UserRepository $repository
    )
    {
    }

    /**
     * @throws InvalidValueException
     * @throws PasswordIncorrectException
     */
    public function __invoke(
        string $id,
        string $email,
        string $name,
        string $password,
        string $createdAt = '',
        string $updatedAt = '',
    ): array
    {
        if (!is_null($this->repository->searchByEmail(new Email($email))))
            throw new DuplicateUserException("The user with such email already exists");

        return $this->repository->save(
            new User(
                new Uuid($id),
                new Email($email),
                new Name($name),
                new Password($password),
                CreatedAt::fromPrimitive($createdAt),
                UpdatedAt::fromPrimitive($updatedAt),
            )
        )->toPrimitives(true);
    }


}
