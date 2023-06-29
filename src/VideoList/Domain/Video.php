<?php

namespace Symfony\Base\VideoList\Domain;

use Symfony\Base\Shared\Domain\AggregateRoot;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

final class Video extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $userId,
        private readonly Name $name,
        private Description $description,
        private readonly Url $url
    ) {
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

    public function changeDescription(string $description): void
    {
        $this->description = $this->description->changeDescription($description);
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
            new Url($video['url']),
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'user_id' => $this->userId()->value(),
            'name' => $this->name()->value(),
            'description' => $this->description()->value(),
            'url' => $this->url()->value(),
        ];
    }
}