<?php

namespace Symfony\Base\Video\Like\Application;

use Symfony\Base\Shared\Domain\EventBus;
use Symfony\Base\Shared\Domain\InvalidValueException;
use Symfony\Base\Video\Like\Domain\Like;
use Symfony\Base\Video\Like\Domain\LikeAlreadyExistsException;
use Symfony\Base\Video\Like\Domain\LikeId;
use Symfony\Base\Video\Like\Domain\LikeRepository;

class CreateLikeUseCase
{

    public function __construct(
        private readonly LikeRepository $repository,
        private readonly EventBus $eventBus
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        DTOLike $likeDTO
    ): void
    {
        $like = $this->repository->find(new LikeId($likeDTO->id));

        if($like !== null) {
            throw new LikeAlreadyExistsException();
        }

        $like = Like::create(
            $likeDTO->id,
            $likeDTO->videoId,
            $likeDTO->userId
        );

        $like->save($this->repository, $this->eventBus);
    }
}