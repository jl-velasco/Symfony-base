<?php

declare(strict_types=1);

namespace Symfony\Base\User\Domain;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class Stats
{
    public function __construct(
        private readonly Uuid $userId,
        private ?VideosCount  $videos = new VideosCount(0)
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
            new VideosCount($values['videos'])
        );
    }

    public function userId(): Uuid
    {
        return $this->userId;
    }

    public function videos(): VideosCount
    {
        return $this->videos ?? new VideosCount(0);
    }

    /**
     * @throws InvalidValueException
     */
    public function increaseVideosCount(?int $count = 1): void
    {
        if ($count < 0) {
            throw new InvalidValueException('$count must be greater than 0');
        }

        $this->videos = new VideosCount($this->videos()->value() + ($count ?? 1));
    }

    /**
     * @throws InvalidValueException
     */
    public function decreaseVideosCount(?int $count = 1): void
    {
        if ($count < 0) {
            throw new InvalidValueException('$count must be greater than 0');
        }

        $this->videos = new VideosCount($this->videos->isBiggerThan(new VideosCount($count))
            ? $this->videos->value() - $count
            : 0
        );
    }
}