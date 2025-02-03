<?php

namespace Symfony\Base\Video\Video\Domain;

use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\CreatedAt;
use Symfony\Base\Shared\Domain\UpdatedAt;
use Symfony\Base\Tweet\Shared\Domain\UserId;
use Symfony\Base\Video\Shared\Domain\VideoId;

class Video extends AggregateRoot
{
    public function __construct(
        private readonly VideoId   $id,
        private UserId             $userId,
        private VideoName          $name,
        private VideoDescription   $description,
        private VideoUrl           $url,
        private VideoLikes         $likes,
        private readonly CreatedAt $createdAt,
        private ?UpdatedAt         $updateAt,
    )
    {
    }

    public function likes(): VideoLikes
    {
        return $this->likes;
    }

    public static function create(
        string $id,
        string $userId,
        string $name,
        string $description,
        string $url,
    ): Video
    {
        $video = new self(
            new VideoId($id),
            new UserId($userId),
            new VideoName($name),
            new VideoDescription($description),
            new VideoUrl($url),
            VideoLikes::create(),
            new CreatedAt(),
            null
        );

        $video->record(
            new VideoCreatedDomainEvent($video->id()->value())
        );

        return $video;
    }

    public function updateName(string $name): void
    {
        $this->name = $this->name->update($name);
        $this->updateAt = new UpdatedAt();
    }

    public function updateDescription(string $description): void
    {
        $this->description = $this->description->update($description);
        $this->updateAt = new UpdatedAt();
    }

    public function updateUrl(string $url): void
    {
        $this->url = $this->url->update($url);
        $this->updateAt = new UpdatedAt();
    }

    public function updateUserId(UserId $userId): void
    {
        $this->userId = $this->userId->update($userId);
        $this->updateAt = new UpdatedAt();
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            new VideoId($data['id']),
            new UserId($data['user_id']),
            new VideoName($data['name']),
            new VideoDescription($data['description']),
            new VideoUrl($data['url']),
            new VideoLikes($data['likes']),
            new CreatedAt($data['created_at']),
            isset($data['updated_at']) ? new UpdatedAt($data['updated_at']) : null
        );
    }

    public function toPrimivites(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'user_id' => $this->userId->value(),
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

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updateAt(): ?UpdatedAt
    {
        return $this->updateAt;
    }

    public function addLike(): void
    {
        $this->likes = $this->likes->addLike();
    }

    public function save(VideoRepository $repository): void
    {
        $repository->save($this);
    }
}