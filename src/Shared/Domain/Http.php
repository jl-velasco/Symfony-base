<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain;

use DomainException;

abstract class Http
{
    abstract public function get(string $url): array;

    abstract public function post(string $url, array $data): array;
}
