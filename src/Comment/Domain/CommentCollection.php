<?php

namespace Symfony\Base\Comment\Domain;

class CommentCollection extends \Symfony\Base\Shared\Domain\Collection
{
    protected function type(): string
    {
        return Comment::class;
    }
}
