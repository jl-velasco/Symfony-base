<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;

final class Video
{
    public function __construct(
        private readonly Uuid        $id,
        private readonly Uuid        $userId,
        private readonly Name        $name,
        private readonly VideoDescription $description,
        private readonly Url         $url,
        private readonly Date        $createdAt,
        private readonly Date        $updatedAt
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
     * @return Uuid
     */
    public function userId(): Uuid
    {
        return $this->userId;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return VideoDescription
     */
    public function description(): VideoDescription
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
     * @return Date
     */
    public function createdAt(): Date
    {
        return $this->createdAt;
    }

    /**
     * @return Date
     */
    public function updatedAt(): Date
    {
        return $this->updatedAt;
    }
}
