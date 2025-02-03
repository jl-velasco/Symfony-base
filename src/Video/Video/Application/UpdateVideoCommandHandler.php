<?php

namespace Symfony\Base\Video\Video\Application;

use Symfony\Base\Shared\Domain\Bus\Command\CommandHandler;
use Symfony\Base\Tweet\Shared\Domain\UserId;
use Symfony\Base\Video\Shared\Domain\VideoId;
use Symfony\Base\Video\Video\Domain\VideoDescription;
use Symfony\Base\Video\Video\Domain\VideoFinder;
use Symfony\Base\Video\Video\Domain\VideoName;
use Symfony\Base\Video\Video\Domain\VideoUrl;

class UpdateVideoCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly VideoFinder $finder
    )
    {
    }

    public function __invoke(UpdateVideoCommand $command): void
    {
        $videoId = new VideoId($command->id);
        $video = $this->finder->findById($videoId);

        $video->updateUserId(new UserId($command->userId));
        $video->updateName(new VideoName($command->name));
        $video->updateDescription(new VideoDescription($command->description));
        $video->updateUrl(new VideoUrl($command->url));
    }
}