<?php

namespace Symfony\Base\Comment\Aplication;

use Symfony\Base\Shared\Domain\Bus\Query\Query;

class GetCommentQuery implements Query
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