<?php

namespace Symfony\Base\Coche;


$coche = new Coche(
    new CocheId('123'),
    new CocheMatricula('1234ABC'),
    new CocheDistance(100, DistanceUnits::KILOMETERS)
);

$coche->sumDistance(100);

class Coche
{
    public function __construct(
        protected CocheId $id,
        protected CocheMatricula $matricula,
        protected CocheDistance $distance,
    )
    {
    }

    public function equals(Coche $other): bool
    {
        return $this->id === $other->id;
    }


    public function sumDistance(float $distance): void
    {
        $this->distance = $this->distance->sum($distance);
//        $newDistance = $this->distance->distance + $distance;
//        $this->distance = new CocheDistance($this->distance->distance, $this->distance->unit);
    }
}