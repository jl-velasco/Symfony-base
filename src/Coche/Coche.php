<?php

namespace Symfony\Base\Coche;;

class Coche
{
    public function __construct(
        protected CocheId $id,
        protected CocheImage $image,
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

    public function id(): CocheId
    {
        return $this->id;
    }

    public function matricula(): CocheMatricula
    {
        return $this->matricula;
    }

    public function comments(): CocheComments
    {
        return $this->comments;
    }

    public function distance(): CocheDistance
    {
        return $this->distance;
    }


    public function sumDistance(float $distance): void
    {
        $this->distance = $this->distance->sum($distance);
    }

    public function updateMatricula(CocheMatricula $matricula)
    {
        $this->matricula = $matricula;
    }

    public function updateComments(CocheComments $comments)
    {
        $this->comments = $comments;
    }

    public function updateDistance(CocheDistance $distance)
    {
        $this->distance = $distance;
    }

    public function save(CocheRepository $cocheRepository)
    {
        $this->validae();
        $cocheRepository->save($this);
    }

    private function validae()
    {
        //TODO:
    }

    public function delete(CocheRepository $repository)
    {
        $this->validate();
        $repository->delete($this->id);
    }

    private function validate()
    {
        //TODO: solo borrar lo pedido inferires a año 2000
    }
}