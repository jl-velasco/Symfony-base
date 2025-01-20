<?php

namespace Symfony\Base\Coche\Application;

class CocheResponse
{
    public function __construct(
        private string $id,
        private string $matricula,
        private array $comentarios,
        private string $distancia
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'matricula' => $this->matricula,
            'comentarios' => $this->comentarios,
            'distancia' => $this->distancia,
        ];
    }
}