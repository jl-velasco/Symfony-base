<?php

declare(strict_types=1);

namespace Symfony\Base\VideoList\Aplication;

use Symfony\Base\Shared\Domain\Bus\Query\Response;

final class VideoResponse implements Response
{
    public function __construct(
        private readonly string  $uuid,
        private readonly string  $userUuid,
        private readonly string  $name,
        private readonly string  $description,
        private readonly string  $url
    )
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'user_id' => $this->userUuid,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url
        ];
    }
}