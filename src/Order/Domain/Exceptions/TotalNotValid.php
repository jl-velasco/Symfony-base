<?php

namespace Symfony\Base\Order\Domain\Exceptions;

use Symfony\Base\Shared\Domain\DomainError;

class TotalNotValid extends DomainError
{
    public function errorCode(): string
    {
        return 'total_not_valid';
    }

    protected function errorMessage(): string
    {
        return 'The total is diferent from the sum of the items';
    }
}