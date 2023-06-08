<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Uuid;

final class Video
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $user_id,
        private readonly VideoName $name,
        private readonly VideoDescription $description,
        private readonly VideoUrl $url,
        private readonly Date $created_at,
        private readonly Date $updated_at
    )
    {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function userId(): Uuid
    {
        return $this->user_id;
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

    public function createdAt(): Date
    {
        return $this->created_at;
    }

    public function updatedAt(): Date
    {
        return $this->updated_at;
    }

}