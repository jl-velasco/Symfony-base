<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Query\Response;

final class VideoProyectionResponse implements Response
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly int $comments
    )
    {
    }

    /** @return array<string, int|string> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'comments' => $this->comments
        ];
    }
}
