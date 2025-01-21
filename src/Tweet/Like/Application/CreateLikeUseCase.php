<?php

namespace Symfony\Base\Tweet\Like\Application;


use Symfony\Base\Tweet\Like\Domain\Like;
use Symfony\Base\Tweet\Like\Domain\LikeAlreadyExistsException;
use Symfony\Base\Tweet\Like\Domain\LikeId;
use Symfony\Base\Tweet\Like\Domain\LikeRepository;

class CreateLikeUseCase
{

    public function __construct(
        private readonly LikeRepository $repository
    )
    {
    }

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
            $likeDTO->tweetId,
            $likeDTO->userId
        );

        $this->repository->save($like);
    }
}