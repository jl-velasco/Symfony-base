<?php
declare(strict_types=1);

namespace Symfony\Base\Comments\Dominio;

use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;

final class Comments
{
    public function __construct(
        private readonly Uuid      $id,
        private readonly Uuid      $videoId,
        private readonly Comment   $comment,
        private readonly UpdatedAt $updatedAt,
        private readonly CreatedAt $createdAt,
    )
    {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function videoId(): Uuid
    {
        return $this->videoId;
    }

    public function comment(): Comment
    {
        return $this->comment;
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
