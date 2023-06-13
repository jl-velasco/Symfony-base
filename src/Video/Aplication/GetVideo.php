<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\VideoFinder;

final class GetVideo
{
    public function __construct(private readonly VideoFinder $finder)
    {
    }

    public function __invoke(string $id): VideoResponse
    {
        $video = $this->finder->__invoke(new Uuid($id));
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