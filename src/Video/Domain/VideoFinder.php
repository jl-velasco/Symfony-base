<?php

declare(strict_types = 1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Exceptions\VideoNotExistException;

final class VideoFinder
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    /**
     * @throws VideoNotExistException
     */
    public function __invoke(Uuid $uuid): Video
    {
        $video = $this->repository->find($uuid);

        if ($video === null) {
            throw new VideoNotExistException((string) $uuid);
        }

        return $video;
    }
}
