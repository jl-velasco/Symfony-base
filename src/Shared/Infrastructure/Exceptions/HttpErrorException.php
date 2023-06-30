<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Exceptions;

use Exception;
use Symfony\Base\Shared\Domain\ValueObject\Url;

class HttpErrorException extends Exception
{
    public function __construct(Url $url)
    {
        parent::__construct(sprintf('Shortener <%s> gives error', $url->value()));
    }
}