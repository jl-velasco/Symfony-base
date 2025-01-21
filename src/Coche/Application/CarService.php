<?php

namespace Symfony\Base\Coche\Application;

use Symfony\Base\Coche\Infrastructure\CarRepository;
class CarService
{
    private CarRepository $carRepository;

    public function __construct(CarRepository $car)
    {
        $this->carRepository = $car;
    }

    public function addComment(string $id, string $comment): void
    {
        $car = $this->carRepository->getCarById($id);
        if ($car) {
            $car->addComment($comment);
            $this->carRepository->saveCar($car);
        }
    }

    public function addLike(string $carId): void
    {
        $car = $this->carRepository->getCarById($carId);
        if ($car) {
            $car->addLike();
            $this->carRepository->saveCar($car);
        }
    }


}