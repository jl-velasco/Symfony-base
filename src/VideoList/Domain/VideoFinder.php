<?php

namespace Symfony\Base\VideoList\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\VideoList\Domain\Exceptions\VideoNotFoundException;

class VideoFinder
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(Uuid $id): Video
    {
        $video = $this->repository->find($id);
        if ($video === null) {
            throw new VideoNotFoundException((string) $id);
        }

        return $video;
    }
}