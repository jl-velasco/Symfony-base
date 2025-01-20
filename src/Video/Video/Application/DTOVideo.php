<?php

namespace Symfony\Base\Video\Video\Application;

class DTOVideo
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $url,
    )
    {
    }
}