<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Dominio;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;

final class Video
{
    public function __construct(
        private readonly Uuid        $id,
        private readonly Uuid        $userId,
        private readonly Name        $name,
        private readonly Description $description,
        private readonly Url         $url,
        private readonly UpdatedAt   $updatedAt,
        private readonly CreatedAt   $createdAt,
    )
    {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function userId(): Uuid
    {
        return $this->userId;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

}
