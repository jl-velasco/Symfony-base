<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Video;
use Symfony\Base\Video\Domain\VideoFinder;

final class GetVideoUseCase
{
    public function __construct(private readonly VideoFinder $finder)
    {
    }

    public function __invoke(string $id): VideoResponse
    {
        $video = $this->finder->__invoke(new Video($id));
        return new VideoResponse(
            $video->uuid()->value(),
            $video->userUuid()->value(),
            $video->name()->value(),
            $video->description()->value(),
            $video->url()->value(),
            $video->createdAt()->stringDateTime(),
            $video->updatedAt()?->stringDateTime()
        );
    }
}
