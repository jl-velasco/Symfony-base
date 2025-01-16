<?php

namespace Symfony\Base\Coche;

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