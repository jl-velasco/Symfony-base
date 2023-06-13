<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Domain\Exceptions;

class VideorNotExistException extends \Exception
{
    public function __construct(string $uuid)
    {
        parent::__construct(sprintf('Video with uuid <%s> not exist', $uuid));
    }
}