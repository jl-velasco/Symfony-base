<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Bus\Event\RabbitMQ;

final class RabbitMqExchangeNameFormatter
{
    public static function retry(string $exchangeName): string
    {
        return "retry_{$exchangeName}";
    }

    public static function deadLetter(string $exchangeName): string
    {
        return "dead_letter_{$exchangeName}";
    }
}