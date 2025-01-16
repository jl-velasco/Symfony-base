<?php

namespace Symfony\Base\Order;

interface StoreFileService
{
    public function store(ImageContent $content): void;

    public function delete(ImageContent $content): void;

    public function update(ImageContent $content): void;


}