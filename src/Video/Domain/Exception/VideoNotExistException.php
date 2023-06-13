<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Domain\Exception;

class VideoNotExistException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Video with id <%s> not exist', $id));
    }
}