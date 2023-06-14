<?php
declare(strict_types=1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Email;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class User extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Email $email,
        private readonly Name $name,
        private readonly Password $password,
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null
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

    public function createdAt(): Date
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?Date
    {
        return $this->updatedAt;
    }

    /**
     * @param array<string, mixed> $user
     * @throws InvalidValueException
     */
    public static function fromArray(array $user): self
    {
        return new self(
            new Uuid($user['id']),
            new Email($user['email']),
            new Name($user['name']),
            new Password($user['password']),
            new Date($user['created_at']),
            $user['updated_at'] ? new Date($user['updated_at']) : null,
        );
    }

    public function delete(): void
    {
        $this->record(
            new UserDeleted(
                $this->id()->value(),
                $this->id()->value(),
            )
        );
    }

    public function toArray()
    {
        return [
            'id' => $this->id()->value(),
            'email' => $this->email()->value(),
            'name' => $this->name()->value(),
            'password' => $this->password()->value(),
            'created_at' => $this->createdAt()->toFormat("Y-m-d H:i:s"),
            'updated_at' => $this->createdAt()->toFormat("Y-m-d H:i:s"),
        ];
    }
}
