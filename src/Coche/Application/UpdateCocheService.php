<?php

namespace Symfony\Base\Coche\Application;

use Symfony\Base\Coche\Domain\CocheComments;
use Symfony\Base\Coche\Domain\CocheDistance;
use Symfony\Base\Coche\Domain\CocheId;
use Symfony\Base\Coche\Domain\CocheMatricula;
use Symfony\Base\Coche\Domain\CocheNotFoundException;
use Symfony\Base\Coche\Domain\CocheRepository;
use Symfony\Base\Coche\DTO;

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