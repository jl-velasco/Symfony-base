<?php

namespace Symfony\Base\Coche;


use Symfony\Base\Shared\Domain\StoreFileService;

class CocheImageValidator
{
    public function __construct(
        private StoreFileService $storeFileService
    ) {
    }

    public function __invoke(CocheImage $image): void
    {
        if($image->size()->value() > 1000000) {
            //logica
        }

        if ($image->name()->value() === 'image.jpg') {
            //logica
        }

        $this->storeFileService->__invoke($image->value());
    }
}