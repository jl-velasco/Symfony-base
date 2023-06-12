<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Dominio;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Video\Dominio\VideoUrl;
use Symfony\Base\Video\Dominio\VideoName;
use Symfony\Base\Video\Dominio\VideoDescription;

final class Video
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $useId,
        private readonly VideoName $name,
        private readonly VideoDescription $description,
        private readonly VideoUrl $url,
        private readonly ?Date $createdAt = new Date(),
        private readonly ?Date $updatedAt = null
    ) {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function useId(): Uuid
    {
        return $this->useId;
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
        return $this->createdAt;
    }

    public function updatedAt(): Date
    {
        return $this->updatedAt;
    }
}
