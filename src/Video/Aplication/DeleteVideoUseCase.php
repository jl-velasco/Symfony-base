<?php

namespace Symfony\Base\Video\Aplication;


use Symfony\Base\Shared\Domain\Bus\Event\EventBus;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoFinder;
use Symfony\Base\Video\Domain\VideoRepository;
use Symfony\Base\Shared\Domain\ValueObject\Video;

class DeleteVideoUseCase
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
     * @throws VideoNotFoundException
     */
    public function __invoke(string $id, string $videoId): void
{
    $video= $this->videoFinder->__invoke(new Video($id));
    $video->deleted();
    $this->videoRepository->delete(new Video($id));
    $this->bus->publish(...$video->pullDomainEvents());
}
}
