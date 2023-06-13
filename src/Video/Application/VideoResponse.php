<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Application;

final class VideoResponse
{
    public function __construct(
        private readonly array $data,
    )
    {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'id' => $this->data['id'],
            'name' => $this->data['name'],
            'description' => $this->data['description'],
            'url' => $this->data['url'],
            'createdAt' => $this->data['created_at'],
            'updatedAt' => $this->data['updated_at'],
        ];
    }
}
