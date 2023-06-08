<?php
declare(strict_types=1);

namespace Symfony\Base\User\Dominio;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Email;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;

final class User
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Email $email,
        private readonly Name $name,
        private readonly Password $password,
        private readonly CreatedAt $createdAt,
        private readonly UpdatedAt $updatedAt,
    )
    {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function password(): Password
    {
        return $this->password;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }
}
