<?php

namespace Symfony\Base\Shared\Infrastructure;

use Symfony\Base\Order\ImageContent;
use Symfony\Base\Shared\Domain\StoreFileService;

class SymfonyStoreFileService implements StoreFileService
{

    public function __construct(

    )
    {
    }

    public function store(ImageContent $content): void
    {

    }

    public function delete(ImageContent $content): void
    {
        // TODO: Implement delete() method.
    }

    public function update(ImageContent $content): void
    {
        // TODO: Implement update() method.
    }
}