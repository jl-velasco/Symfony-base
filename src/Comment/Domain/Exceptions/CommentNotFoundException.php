<?php

declare(strict_types=1);

namespace Symfony\Base\Comment\Domain\Exceptions;

use Exception;

final class CommentNotFoundException extends Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Comment with id <%s> does not exists', $id));
    }
}