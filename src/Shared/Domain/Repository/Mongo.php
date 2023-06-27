<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\Repository;

use MongoDB\Collection;

interface Mongo
{
    public function collection(string $collection): Collection;
}