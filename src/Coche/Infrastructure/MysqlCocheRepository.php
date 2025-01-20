<?php

namespace Symfony\Base\Coche\Infrastructure;

use PgSql\Connection;
use Symfony\Base\Coche\Domain\Coche;
use Symfony\Base\Coche\Domain\CocheId;
use Symfony\Base\Coche\Domain\CocheRepository;

class MysqlCocheRepository implements CocheRepository
{

    public function __construct(
       private Connection $connection,
    )
    {
    }

    public function findBy(CocheId $id): ?Coche
    {
        $this->connection->query('SELECT * FROM coches WHERE id = :id', ['id' => $id->value()]);
    }

    public function save(Coche $coche): void
    {
        $this->connection->query('INSERT INTO coches (id, name, brand) VALUES (:id, :name, :brand)', [
            'id' => $coche->id()->value(),
            'name' => $coche->name()->value(),
            'brand' => $coche->brand()->value(),
        ]);
    }

    public function delete(CocheId $id): void
    {
        $this->connection->query('DELETE FROM coches WHERE id = :id', ['id' => $id->value()]);
    }
}