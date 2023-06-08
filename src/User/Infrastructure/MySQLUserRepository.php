<?php
declare(strict_types=1);

namespace Symfony\Base\User\Infrastructure;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\User\Dominio\User;
use Symfony\Base\User\Dominio\UserRepository;

class MySQLUserRepository implements UserRepository
{
    public function save(User $user): void
    {

    }

    public function search(Uuid $id): User
    {

    }

    public function delete(Uuid $id): void
    {
        // TODO: Implement delete() method.
    }
}
