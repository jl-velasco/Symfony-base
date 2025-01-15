<?php

declare(strict_types=1);

namespace CGE\Member\Shared\Domain\ValueObject;

use CGE\Member\Shared\Domain\Exception\InvalidValueException;
use DateTimeImmutable;
use DateTimeZone;

class Date
{
    private const string TIMEZONE = 'UTC';

    private const string DATABASE_TIMESTAMP_FORMAT = 'Y-m-d H:i:s.u';

    protected DateTimeImmutable $date;

    /** @throws InvalidValueException */
    public function __construct(?string $date = null)
    {
        try {
            $this->date = $date ?
                new DateTimeImmutable($date, $this->getTimezone()) :
                new DateTimeImmutable('now', $this->getTimezone());
        } catch (\Throwable $e) {
            throw new InvalidValueException(
                self::class,
                $date,
                'The value is not a valid date'
            );
        }
    }

    public function __toString(): string
    {
        return $this->stringDateTime();
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function timeStamp(): int
    {
        return $this->date->getTimestamp();
    }

    public function stringDateTime(): string
    {
        return $this->date
            ->format(self::DATABASE_TIMESTAMP_FORMAT);
    }

    public function modify(string $modifier): self
    {
        $this->date = (new DateTimeImmutable())->modify($modifier);

        return $this;
    }

    public function isInThePast(): bool
    {
        return $this->date < new DateTimeImmutable();
    }

    public function year(): int
    {
        return (int) $this->date->format('Y');
    }

    public function month(): int
    {
        return (int) $this->date->format('m');
    }

    public function toFormat(string $format): string
    {
        return $this->date->format($format);
    }

    public function isGreatherThan(Date $date): bool
    {
        $dateInterval = $this->date->diff($date->date());

        return !($dateInterval->format('%R%a') >= 0);
    }

    private function getTimezone(): DateTimeZone
    {
        return new \DateTimeZone(self::TIMEZONE);
    }
}
