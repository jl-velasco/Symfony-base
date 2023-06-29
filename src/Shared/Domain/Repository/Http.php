<?php

namespace Symfony\Base\Shared\Domain\Repository;

interface Http
{
    public function get(string $url, ?array $params = []): string;
}