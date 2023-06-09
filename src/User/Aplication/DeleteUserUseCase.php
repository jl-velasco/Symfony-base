<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;

use Symfony\Base\Shared\ValueObject\Email;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\User\Domain\Password;
use Symfony\Base\User\Domain\User;
use Symfony\Base\User\Domain\UserRepository;

class DeleteUserUseCase
{
    public function __construct(
        private readonly UserRepository $repository
    )
    {
    }

    public function __invoke(string $id): void
    {
        $this->repository->delete(new Uuid($id));
    }
}