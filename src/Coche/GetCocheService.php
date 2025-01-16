<?php

namespace Symfony\Base\Coche;

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