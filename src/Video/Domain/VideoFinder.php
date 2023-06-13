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
    public function __invoke(Uuid $id): Video
    {
        $Video = $this->repository->find($id);

        if ($Video === null) {
            throw new VideoNotExistException((string) $id);
        }

        return $Video;
    }
}