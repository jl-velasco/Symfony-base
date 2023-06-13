<?php

namespace Symfony\Base\Video\Domain\Exceptions;

class VideoNotFoundException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Video with id <%s> not exist', $id));
    }
}
