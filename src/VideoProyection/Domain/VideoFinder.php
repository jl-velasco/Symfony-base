<?php

declare(strict_types=1);

namespace Symfony\Base\VideoProyection\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;

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
        $video = $this->repository->search($id);
        if ($video === null) {
            throw new VideoNotFoundException((string) $id);
        }

        return $video;
    }
}