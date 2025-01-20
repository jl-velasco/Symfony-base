<?php

namespace Symfony\Base\Coche\Application;

use Symfony\Base\Coche\Domain\CocheId;
use Symfony\Base\Coche\Domain\CocheNotFoundException;
use Symfony\Base\Coche\Domain\CocheRepository;

class GetCocheService
{

    public function __construct(
        private CocheRepository $cocheRepository
    ) {
    }

    public function __invoke(int $id): CocheResponse
    {
        $coche =  $this->cocheRepository->findBy(new CocheId($id));

        if (!$coche) {
            throw new CocheNotFoundException();
        }

        return new CocheResponse(
            $coche->id()->value(),
            $coche->matricula()->value(),
            $coche->comments()->toArray(),
            $coche->distance()->value()
        );
    }

}