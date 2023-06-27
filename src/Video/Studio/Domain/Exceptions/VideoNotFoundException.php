<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Studio\Domain\Exceptions;

use Exception;

final class VideoNotFoundException extends Exception
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Video with id <%s> does not exists', $id));
    }
}