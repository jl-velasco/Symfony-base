<?php

namespace Symfony\Base\Order\Domain;

use Symfony\Base\Order\StoreFileService;

class OrderImageValidator
{
    public function __construct(
        private StoreFileService $storeFileService
    )
    {
    }

    public function validate(OrderImage $image): void
    {
        if ($image->content()->size() > 1000000) {
            $this->storeFileService->store('path', $image->content());
        } else {
            $this->storeFileService->store('path2', $image->content());
        }
    }
}