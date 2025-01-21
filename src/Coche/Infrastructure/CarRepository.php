<?php

namespace Symfony\Base\Coche\Infrastructure;

class CarRepository
{
    private array $cars = [];

    public function __construct()
    {
        $this->cars = [];
    }

    public function saveCar($car): void
    {
        $this->cars[] = $car;
    }

    public function countCars(): int
    {
        return count($this->cars);
    }

    public function getCars(): array
    {
        return $this->cars;
    }

    public function getCarById(string $id): ?\Symfony\Base\Coche\Domain\Car
    {
        return $this->cars[$id];
    }
}