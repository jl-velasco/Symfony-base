<?php

namespace Symfony\Base\Coche;

class UpdateCocheService
{
    public function __construct(
        private CocheRepository $cocheRepository
    )
    {
    }

    public function __invoke(
        DTO $cochedto
    ): void
    {
        $coche = $this->cocheRepository->findBy(new CocheId($cochedto->id));

        if ($coche === null) {
            throw new CocheNotFoundException();
        }

        $coche->updateMatricula(new CocheMatricula($cochedto->matricula));
        $coche->updateComments(new CocheComments($cochedto->comments));
        $coche->updateDistance(new CocheDistance($cochedto->distance));
        $coche->save($this->cocheRepository);
    }
}