<?php

namespace Symfony\Base\Video\Video\Domain;

use Symfony\Base\Shared\Domain\CreatedAt;
use Symfony\Base\Shared\Domain\UpdatedAt;
use Symfony\Base\Video\Shared\Domain\VideoId;

class Video
{
    public function __construct(
        private readonly VideoId $id,
        private readonly VideoName $name,
        private readonly VideoDescription $description,
        private readonly VideoUrl $url,
        private readonly CreatedAt $createdAt,
        private readonly ?UpdatedAt $updateAt,
    )
    {
    }

    public static function create(
        string $id,
        string $name,
        string $description,
        string $url,
    ): Video
    {
        return new self(
            new VideoId($id),
            new VideoName($name),
            new VideoDescription($description),
            new VideoUrl($url),
            new CreatedAt(),
            null
        );
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            new VideoId($data['id']),
            new VideoName($data['name']),
            new VideoDescription($data['description']),
            new VideoUrl($data['url']),
            new CreatedAt($data['created_at']),
            new UpdatedAt($data['updated_at'])
        );
    }

    public function toPrimivites(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'description' => $this->description->value(),
            'url' => $this->url->value(),
            'created_at' => $this->createdAt->stringDateTime(),
            'updated_at' => $this->updateAt->stringDateTime(),
        ];
    }

    public function id(): VideoId
    {
        return $this->id;
    }

    public function name(): VideoName
    {
        return $this->name;
    }

    public function description(): VideoDescription
    {
        return $this->description;
    }

    public function url(): VideoUrl
    {
        return $this->url;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updateAt(): UpdatedAt
    {
        return $this->updateAt;
    }
}