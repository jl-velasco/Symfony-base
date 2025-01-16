<?php

namespace Symfony\Base\Coche;;

class Coche
{
    public function __construct(
        protected CocheId $id,
        protected CocheMatricula $matricula,
        protected CocheComments  $comments,
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
    }
}