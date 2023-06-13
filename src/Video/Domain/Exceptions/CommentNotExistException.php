<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Domain\Exceptions;

class CommentNotExistException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Comment with id <%s> not exist', $id));
    }
}