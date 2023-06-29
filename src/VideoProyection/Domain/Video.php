<?php

namespace Symfony\Base\VideoProyection\Domain;

use Exception;
use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class Video extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly Uuid $userUuid,
        private readonly Name $name,
        private readonly Description $description,
        private readonly Url $url
    ) {
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function userUuid(): Uuid
    {
        return $this->userUuid;
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

    /**
     * @param array<string, mixed> $video
     * @throws InvalidValueException
     */
    public static function fromArray(array $video): self
    {
        return new self(
            new Uuid($video['id']),
            new Uuid($video['user_id']),
            new Name($video['name']),
            new Description($video['description']),
            new URL($video['url']),

        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->uuid()->value(),
            'user_id' => $this->userUuid()->value(),
            'name' => $this->name()->value(),
            'description' => $this->description()->value(),
            'url' => $this->url()->value(),
        ];
    }
}