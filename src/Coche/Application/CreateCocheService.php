<?php

namespace Symfony\Base\Coche\Application;

use Symfony\Base\Coche\CocheAlreadyExistsException;
use Symfony\Base\Coche\Domain\Coche;
use Symfony\Base\Coche\Domain\CocheComments;
use Symfony\Base\Coche\Domain\CocheDistance;
use Symfony\Base\Coche\Domain\CocheId;
use Symfony\Base\Coche\Domain\CocheMatricula;
use Symfony\Base\Coche\Domain\CocheRepository;
use Symfony\Base\Coche\Domain\DistanceUnits;

class CreateCocheService
{

        public function __construct(private CocheRepository $repository)
        {
        }

        public function __invoke(DTOCoche $coche): void
        {
            $coche = $this->repository->findBy(new CocheId($coche->id));

            if ($coche !== null) {
                throw new CocheAlreadyExistsException();
            }

            $coche = new Coche(
                new CocheId($coche->id),
                new CocheMatricula($coche->matricula),
                new CocheComments($coche->comentarios),
                new CocheDistance($coche->distancia, DistanceUnits::tryFrom($coche->units)),
            );


            $this->repository->save($coche);
        }
}