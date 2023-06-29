<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain;

interface Short
{
    public function short(string $url): string;
}
