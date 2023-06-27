<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Mongo;

use MongoDB\Client;
use MongoDB\Collection;
use Symfony\Base\Shared\Domain\Repository\Mongo;

final class MongoDBClient implements Mongo
{
    public function __construct(
        private readonly Client $client,
        private readonly string $databaseName
    ) {
    }

    public function collection(string $collection): Collection
    {
        return $this->client->selectCollection($this->databaseName, $collection);
    }
}
