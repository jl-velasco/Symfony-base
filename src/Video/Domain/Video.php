<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class Video
{
    public function __construct(private readonly Uuid $id,
                                private Name          $name,
                                private Description   $description,
                                private Url           $url,
                                private User          $user,
                                private Date          $createdAt,
                                private ?Date         $updatedAt = null)
    {
    }

    public function id(): Uuid
    {
        return $this->id;
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

    public function user(): User
    {
        return $this->user;
    }

    public function createdAt(): Date
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?Date
    {
        return $this->updatedAt;
    }

    public function withName(Name $name): Video
    {
        $this->name = $name;
        return $this;
    }

    public function withDescription(Description $description): Video
    {
        $this->description = $description;
        return $this;
    }

    public function withUrl(Url $url): Video
    {
        $this->url = $url;
        return $this;
    }

    public function withUser(User $user): Video
    {
        $this->user = $user;
        return $this;
    }

    public function withCreatedAt(Date $createdAt): Video
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function withUpdatedAt(Date $updatedAt): Video
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
