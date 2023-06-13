<?php

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;

class Video
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $userId,
        private readonly Name $name,
        private readonly Description $description,
        private readonly Url $url,
        private readonly ?CreatedAt $createdAt,
        private readonly ?UpdatedAt $updatedAt,
    )
    {
    }

    /**
     * @return Uuid
     */
    public function id(): Uuid
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return Description
     */
    public function description(): Description
    {
        return $this->description;
    }

    /**
     * @return Url
     */
    public function url(): Url
    {
        return $this->url;
    }

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * @return UpdatedAt
     */
    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    /**
     * @return Uuid
     */
    public function userId(): Uuid
    {
        return $this->userId;
    }

    public function toPrimitives(): array
    {
        $result = [
            'id' => $this->id()->value(),
            'user_id' => $this->userId()->value(),
            'name' => $this->name()->value(),
            'description' => $this->description()->value(),
            'url' => $this->url()->value(),
            'created_at' => (string)$this->createdAt(),
            'updated_at' => (string)$this->updatedAt(),
        ];

        return $result;
    }

    static public function fromPrimitives($data): Video
    {
        return new self(
            new Uuid($data['id']),
            new Uuid($data['user_id']),
            new Name($data['name']),
            new Description($data['description']),
            new Url($data['url']),
            CreatedAt::fromPrimitive($data['created_at']),
            UpdatedAt::fromPrimitive($data['updated_at']),
        );
    }
}
