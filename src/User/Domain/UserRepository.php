<?php
declare(strict_types=1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\ValueObject\Uuid;

interface UserRepository
{
    public function save(User $user): void;

    public function search(Uuid $id): ?User;

    public function delete(Uuid $id): void;
}