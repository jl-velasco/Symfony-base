<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\CreatedAt;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Domain\ValueObject\Email;
use Symfony\Base\User\Aplication\Exceptions\DuplicateUserException;
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
        string $password,
        string $createdAt = '',
        string $updatedAt = '',
    ): UserResponse
    {
        if (
            is_null($this->repository->search(new Uuid($id))) &&
            !is_null($this->repository->searchByEmail(new Email($email)))
        )
            throw new DuplicateUserException("The user with such email already exists");

        return new UserResponse($this->repository->save(
            new User(
                new Uuid($id),
                new Email($email),
                new Name($name),
                new Password($password),
                new Date($createdAt),
                new Date($updatedAt)
            )
        )->toArray());
    }


}
