<?php

namespace Symfony\Base\Video\Video\Application;

use Symfony\Base\Video\Video\Domain\Exceptions\VideoAlreadyExistsException;
use Symfony\Base\Video\Video\Domain\Exceptions\VideoNotFound;
use Symfony\Base\Video\Video\Domain\Video;
use Symfony\Base\Video\Video\Domain\VideoFinder;
use Symfony\Base\Video\Video\Domain\VideoId;
use Symfony\Base\Video\Video\Domain\VideoRepository;

class CreateVideoUseCase
{
    public function __construct(
        private readonly VideoRepository $repository,
        private readonly VideoFinder     $finder
    )
    {
    }

    public function __invoke(
        DTOVideo $dto
    ): void
    {
        try {
            $this->ensureIfVideoExist($dto);
        } catch (VideoNotFound) {
            $video = Video::create(
                $dto->id,
                $dto->name,
                $dto->description,
                $dto->url,
            );

            $this->repository->save($video);
        }
    }

    public function ensureIfVideoExist(DTOVideo $dto): void
    {
        $this->finder->findById(new VideoId($dto->id));

        throw new VideoAlreadyExistsException();
    }
}