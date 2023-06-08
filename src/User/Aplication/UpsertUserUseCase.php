<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Email;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;
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

    public function __invoke(
        string $id,
        string $email,
        string $name,
        string $password,
        string $createdAt,
        string $updatedAt,
    ): void
    {
        $this->repository->save(
            new User(
                new Uuid($id),
                new Email($email),
                new Name($name),
                new Password($password),
                new CreatedAt(new \DateTime($createdAt)),
                new UpdatedAt(new \DateTime($updatedAt)),
            )
        );
    }


}
