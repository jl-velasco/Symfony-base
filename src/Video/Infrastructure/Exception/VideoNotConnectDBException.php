<?php
declare(strict_types = 1);

namespace Symfony\Base\Video\Infrastructure\Exception;

class VideoNotConnectDBException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Video with problem connect database', $id));
    }
}