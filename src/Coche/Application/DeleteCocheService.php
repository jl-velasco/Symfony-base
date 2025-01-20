<?php

namespace Symfony\Base\Coche\Application;

use Symfony\Base\Coche\Domain\CocheId;
use Symfony\Base\Coche\Domain\CocheNotFoundException;
use Symfony\Base\Coche\Domain\CocheRepository;

class DeleteCocheService
{

    public function __construct(private CocheRepository $repository)
    {
    }

    public function __invoke(CocheId $id): void
    {
        $coche = $this->repository->findBy($id);

        if (null === $coche) {
            throw new CocheNotFoundException();
        }
        $coche->delete($this->repository);
    }

}