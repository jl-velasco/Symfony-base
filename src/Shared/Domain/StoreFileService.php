<?php

namespace Symfony\Base\Shared\Domain;

use Symfony\Base\Order\ImageContent;

interface StoreFileService
{
    public function store(ImageContent $content): void;

    public function delete(ImageContent $content): void;

    public function update(ImageContent $content): void;


}