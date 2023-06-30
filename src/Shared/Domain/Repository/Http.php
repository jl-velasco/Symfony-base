<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\Repository;

interface Http
{
    /**
     * @param array<string, mixed> $headers
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    public function post(string $url, array $headers = [], array $body = []): array;
}