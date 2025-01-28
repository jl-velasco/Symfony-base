<?php

namespace Symfony\Base\Video\Video\Application;

use Symfony\Base\Shared\Domain\Bus\QueryHandler;
use Symfony\Base\Video\Shared\Domain\VideoId;
use Symfony\Base\Video\Video\Domain\VideoFinder;

class GetVideoQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly VideoFinder $finder
    )
    {
    }

    public function __invoke(GetVideoQuery $query): VideoResponse
    {
        $videoId = new VideoId($query->id);

        $video = $this->finder->findById($videoId);

        return new VideoResponse(
            $video->id()->value(),
            $video->userId()->value(),
            $video->name()->value(),
            $video->description()->value(),
            $video->url()->value(),
            $video->likes()->value()
        );
    }
}