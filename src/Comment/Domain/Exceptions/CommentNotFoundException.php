<?php

namespace Symfony\Base\Comment\Domain\Exceptions;

class CommentNotFoundException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Comment with id <%s> not exist', $id));
    }
}
