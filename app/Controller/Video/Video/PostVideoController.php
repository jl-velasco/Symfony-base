<?php

namespace Symfony\Base\App\Controller\Video\Video;

use Symfony\Base\Video\Video\Application\CreateVideoUseCase;
use Symfony\Base\Video\Video\Application\DTOVideo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostVideoController
{
    public function __construct(
        private readonly CreateVideoUseCase $useCase
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
            new DTOVideo(
                $data['id'],
                $data['user_id'],
                $data['name'],
                $data['description'],
                $data['url']
            )
        );

        return new Response(status: Response::HTTP_ACCEPTED);
    }

    //TODO: comprobar los datos del body

}