<?php

namespace Symfony\Base\Coche;

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