<?php

namespace Symfony\Base\Video\Video\Application;

use Symfony\Base\Shared\Domain\Bus\Query\Response;

class VideoResumeResponse implements Response
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $description,
    )
    {
    }

    public function toPrimitives(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}