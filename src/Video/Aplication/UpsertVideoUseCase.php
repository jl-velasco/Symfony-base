<?php

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class UpsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly EventBus $bus
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $uuid,
        string $userUuid,
        string $name,
        string $description,
        string $url
    ): void
    {
        $videoId = new Uuid($uuid);
        $this->repository->save(
            new Video(
                $videoId,
                new Uuid($userUuid),
                new Name($name),
                new Description($description),
                new Url($url)
            )
        );
        $video = $this->repository->find($videoId);
        if ($video->isNew()) {
            $video->add();
            $this->bus->publish(...$video->pullDomainEvents());
        }
    }
}