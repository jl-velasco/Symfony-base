<?php

namespace Symfony\Base\Video\Studio\Application;

use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Studio\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Studio\Domain\Video;
use Symfony\Base\Video\Studio\Domain\VideoFinder;
use Symfony\Base\Video\Studio\Domain\VideoRepository;

class UpsertVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $videoRepository,
        private readonly VideoFinder $videoFinder,
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
        try {
            $this->videoFinder->__invoke(new Uuid($uuid));
            $video = new Video(
                new Uuid($uuid),
                new Uuid($userUuid),
                new Name($name),
                new Description($description),
                new Url($url)
            );
        } catch (VideoNotFoundException) {
            $video = Video::create(
                new Uuid($uuid),
                new Uuid($userUuid),
                new Name($name),
                new Description($description),
                new Url($url)
            );
        }
        $this->videoRepository->save($video);
        $this->bus->publish(...$video->pullDomainEvents());
    }
}