<?php

namespace Symfony\Base\Coche\Domain;

interface CocheRepository
{
    public function findBy(CocheId $id): ?Coche;

    public function save(Coche $coche): void;

    public function delete(CocheId $id): void;
}