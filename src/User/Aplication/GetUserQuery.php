<?php
declare(strict_types=1);

namespace Symfony\Base\User\Aplication;


use Symfony\Base\Shared\Domain\Bus\Query\Query;

class GetUserQuery implements Query
{
    public function __construct(
        private readonly string $id
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}