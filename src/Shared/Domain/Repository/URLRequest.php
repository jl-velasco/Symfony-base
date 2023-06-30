<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\Repository;

use Symfony\Base\Shared\Domain\ValueObject\Url;

interface URLRequest
{
    public function request(string $type, Url $url): string;
}