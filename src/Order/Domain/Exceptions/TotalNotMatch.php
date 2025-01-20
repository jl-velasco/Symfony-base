<?php

namespace Symfony\Base\Order\Domain\Exceptions;

use Symfony\Base\Shared\Domain\DomainError;

class TotalNotMatch extends DomainError
{
    public function __construct()
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'order_total_not_match';
    }

    protected function errorMessage(): string
    {
        return 'The total of the order does not match the sum of the items';
    }
}