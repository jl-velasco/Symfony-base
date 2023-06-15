<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Video;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;

final class VideoFinder
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(Video $id): Video
    {
        $video = $this->repository->find($id);
        if ($video === null) {
            throw new VideoNotFoundException((string) $id);
        }

        return $video;
    }
}
