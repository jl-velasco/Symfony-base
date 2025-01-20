<?php

namespace Symfony\Base\Coche\Application;

class DTOCoche
{
    public function __construct(
        public readonly string $id,
        public readonly string $matricula,
        public readonly float $distancia,
        public readonly string $units,
        public readonly array $comentarios,
    )
    {
    }
}