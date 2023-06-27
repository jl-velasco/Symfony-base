<?php
declare(strict_types=1);

namespace Symfony\Base\Registater\Domain;

use Symfony\Base\Registater\Domain\Exceptions\UserCreatedDomainEvent;
use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Email;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\VideoCounter;

final class User extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Email $email,
        private readonly Name $name,
        private readonly Password $password,
        private ?VideoCounter $videoCounter = new VideoCounter(0),
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null
    ) {
    }

    public static function create(
        Uuid $id,
        Email $email,
        Name $name,
        Password $password,
    ): self
    {
        $user = new self(
            $id,
            $email,
            $name,
            $password,
        );

        $user->record(
            new UserCreatedDomainEvent(
                $id->value(),
                $name->value()
            )
        );

        return $user;
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

    public function videoCounter(): VideoCounter
    {
        return $this->videoCounter;
    }

    public function increaseVideoCounter(): void
    {
        $this->videoCounter = $this->videoCounter->increase();
    }

    public function decreaseVideoCounter(): void
    {
        $this->videoCounter = $this->videoCounter->decrease();
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
            new VideoCounter($user['count_video'] ?? 0),
            new Date($user['created_at']),
            $user['updated_at'] ? new Date($user['updated_at']) : null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'email' => $this->email()->value(),
            'name' => $this->name()->value(),
            'password' => $this->password()->value(),
            'video_counter' => $this->videoCounter()->value(),
            'created_at' => $this->createdAt()->stringDateTime(),
            'updated_at' => $this->updatedAt()?->stringDateTime(),
        ];
    }

    public function delete(): void
    {
        $this->record(
            new UserDeletedDomainEvent(
                $this->id()->value(),
            )
        );
    }
}