<?php

namespace Symfony\Base\Video\Video\Domain;

use Symfony\Base\Video\Video\Domain\Exceptions\VideoNotFound;

class VideoFinder
{
    public function __construct(
        private readonly VideoRepository $repository
    )
    {
    }

    public function findById(VideoId $id): ?Video
    {
        $video = $this->repository->search($id);

        if ($video === null) {
            throw new VideoNotFound();
        }

        return $video;
    }
}