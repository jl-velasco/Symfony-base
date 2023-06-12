<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure;

abstract class DbalRepository
{
    public function __construct(protected readonly object $connection)
    {
    }
}
