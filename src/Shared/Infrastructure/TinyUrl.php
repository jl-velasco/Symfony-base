<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure;

use Symfony\Base\Shared\Domain\Short;

class TinyUrl implements Short
{
    public function __construct(
        private readonly Http $http,
    )
    {
    }
    public function short(string $url): string
    {
        // TODO: return correct value
        $short = $this->http->post(
            sprintf(
                'https://tinyurl.com/api-create.php?url=%s',
                $url
            )
        );
        return $short;
    }
}
