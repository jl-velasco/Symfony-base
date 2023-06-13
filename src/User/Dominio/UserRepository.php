<?php
declare(strict_types=1);

namespace Symfony\Base\User\Dominio;

use Symfony\Base\Shared\ValueObject\Email;
use Symfony\Base\Shared\ValueObject\Uuid;

interface UserRepository
{
    public function save(User $user): User;

    public function search(Uuid $id): User|null;

    public function searchByEmail(Email $email): User|null;

    public function delete(Uuid $id): void;
}
