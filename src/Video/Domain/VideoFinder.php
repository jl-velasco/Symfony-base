<?php

declare(strict_types = 1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\User\Domain\Video;
use Symfony\Base\Video\Domain\Exception\VideoNotExistException;

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
        $video = $this->repository->find($id);

        // TODO: crear la excepcion de dominio
        if ($video === null) {
            throw new VideoNotExistException((string) $id);
        }

        return $video;
    }
}
