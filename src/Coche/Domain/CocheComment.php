<?php

namespace Symfony\Base\Coche\Domain;

class CocheComment
{
    public function __construct(
        protected CocheCommentId $id,
    )
    {
    }

    public function equals(CocheComment $other): bool
    {
        return $this->id === $other->id;
    }
}