<?php

namespace Symfony\Base\Order;

use Symfony\Base\Shared\Domain\DomainError;

class ItemAlreadyExists extends DomainError
{
    public function errorCode(): string
    {
        return 'item_already_exists';
    }

    protected function errorMessage(): string
    {
        return 'The item already exists in the order';
    }
}