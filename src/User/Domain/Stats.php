<?php

declare(strict_types=1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class Stats
{
    public function __construct(
        private readonly Uuid $userId,
        private ?VideoCount $videos = new VideoCount(0)
    )
    {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function fromArray(array $values): self
    {
        return new self(
            new Uuid($values['id']),
            new VideoCount($values['videos'])
        );
    }

    public function userId(): Uuid
    {
        return $this->userId;
    }

    public function videos(): VideoCount
    {
        return $this->videos ?? new VideoCount(0);
    }

    /**
     * @throws InvalidValueException
     */
    public function increaseVideosCount(?int $count = 1): void
    {
        if ($count < 0) {
            throw new InvalidValueException('$count must be greater than 0');
        }

        $this->videos = new VideoCount($this->videos()->value() + ($count ?? 1));
    }

    /**
     * @throws InvalidValueException
     */
    public function decreaseVideosCount(?int $count = 1): void
    {
        if ($count < 0) {
            throw new InvalidValueException('$count must be greater than 0');
        }

        $this->videos = new VideoCount($this->videos->isBiggerThan(new VideoCount($count))
            ? $this->videos->value() - $count
            : 0
        );
    }
}
