<?php
declare(strict_types=1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Shared\Domain\ValueObject\Email;

interface UserRepository
{
    public function save(User $user): User;

    public function search(Uuid $id): User|null;

    public function searchByEmail(Email $email): User|null;

    public function delete(Uuid $id): void;
    public function incrementVideo(Uuid $id): void;
    public function decrementVideo(Uuid $id): void;
}
