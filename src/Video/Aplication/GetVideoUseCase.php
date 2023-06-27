<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Base\Video\Domain\VideoFinder;

final class GetVideoUseCase implements CommandHandler
{
    public function __construct(private readonly VideoFinder $finder)
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(GetVideoUserCommand $command): VideoResponse
    {
        $video = $this->finder->__invoke(new Uuid($command->id()));

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
