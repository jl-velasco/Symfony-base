<?php
declare(strict_types=1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class User extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Name $name,
        private ?VideoCounter $videoCounter = new VideoCounter(0)
    ) {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
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
            new Name($user['name']),
            new VideoCounter($user['count_video'] ?? 0),
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'name' => $this->name()->value(),
            'video_counter' => $this->videoCounter()->value(),
        ];
    }

//    public function delete(): void
//    {
//        $this->record(
//            new UserDeletedDomainEvent(
//                $this->id()->value(),
//            )
//        );
//    }
}