<?php

namespace Symfony\Base\VideoProyection\Domain;

use Symfony\Base\Registation\Domain\Exceptions\UserNotExistException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;
use Symfony\Base\Video\Domain\Video;
use Symfony\Base\Video\Domain\VideoRepository;

class VideoProyectionFinder
{
    public function __construct(private readonly VideoProyectionRepository $repository)
    {
    }

    /**
     * @throws UserNotExistException
     */
    public function __invoke(Uuid $id): Video
    {
        $video = $this->repository->search($id);

        if ($video === null) {
            throw new VideoNotExistException((string) $id);
        }

        return $video;
    }
}