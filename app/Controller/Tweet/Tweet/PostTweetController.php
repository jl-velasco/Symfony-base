<?php

namespace Symfony\Base\App\Controller\Tweet\Tweet;

use Symfony\Base\Tweet\Tweet\Application\CreateTweetService;
use Symfony\Base\Tweet\Tweet\Application\TweetDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostTweetController
{
    public function __construct(
        private readonly CreateTweetService $useCase
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
            new TweetDTO(
                $data['id'],
                $data['user_id'],
                $data['content']
            )
        );

        return new Response();
    }
}