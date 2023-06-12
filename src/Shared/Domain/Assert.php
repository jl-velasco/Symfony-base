<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain;

use Symfony\Base\Shared\Domain\Exception\InvalidTypeException;

final class Assert
{
    /**
     * @throws InvalidTypeException
     */
    public static function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            self::instanceOf($class, $item);
        }
    }

    /**
     * @throws InvalidTypeException
     */
    public static function instanceOf(string $class, $item): void
    {
        if (!$item instanceof $class) {
            throw new InvalidTypeException($class, $item::class);
        }
    }
}
