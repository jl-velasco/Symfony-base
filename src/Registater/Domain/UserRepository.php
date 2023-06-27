<?php
declare(strict_types=1);

namespace Symfony\Base\Registater\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;

interface UserRepository
{
    public function save(User $user): void;

    public function search(Uuid $id): ?User;

    public function delete(Uuid $id): void;
}