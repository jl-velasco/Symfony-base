<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain\Exceptions;

use Exception;


final class WrongUrlException extends Exception
{
    public function __construct(string $url)
    {
        parent::__construct(sprintf('Error generating short url from  <%s>' , $url));
    }
}
