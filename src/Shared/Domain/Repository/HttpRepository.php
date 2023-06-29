<?php
declare(strict_types=1);

namespace Symfony\Base\Shared\Domain\Repository;

use Symfony\Base\Shared\Domain\ValueObject\HttpRequestType;
use Symfony\Base\Shared\Domain\ValueObject\Url;

interface HttpRepository
{
    public function send(Url $url, HttpRequestType $requestType): string;

}