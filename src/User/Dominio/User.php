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

    public function toPrimitives($withoutPassword = false): array
    {
        $result = [
            'id' => $this->id()->value(),
            'email' => $this->email()->value(),
            'name' => $this->name()->value(),
            'password' => $this->password()->value(),
            'created_at' => (string)$this->createdAt(),
            'updated_at' => (string)$this->updatedAt(),
        ];

        if ($withoutPassword)
            unset($result['password']);

        return $result;
    }

    static public function fromPrimitives($data): User
    {
        return new self(
            new Uuid($data['id']),
            new Email($data['email']),
            new Name($data['name']),
            new Password($data['password']),
            CreatedAt::fromPrimitive($data['created_at']),
            UpdatedAt::fromPrimitive($data['updated_at']),
        );
    }
}
