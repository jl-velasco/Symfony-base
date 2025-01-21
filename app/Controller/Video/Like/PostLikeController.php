<?php

namespace Symfony\Base\App\Controller\Video\Like;

use Symfony\Base\Video\Like\Application\CreateLikeUseCase;
use Symfony\Base\Video\Like\Application\DTOLike;
use Symfony\Base\Video\Video\Application\DTOVideo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostLikeController
{
    public function __construct(
        private readonly CreateLikeUseCase $useCase
    )
    {
    }

    /**
     * @throws \JsonException
     */
    public function __invoke(
        Request $request
    ): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->useCase->__invoke(
            new DTOLike(
                $data['id'],
                $data['user_id'],
                $data['video_id'],
            )
        );

        return new Response();
    }
}