<?php

namespace Symfony\Base\Coche;

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