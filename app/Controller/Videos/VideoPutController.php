<?php

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\User\Aplication\UpsertVideoCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Base\Video\Aplication\UpsertVideoUseCase;
use Symfony\Component\HttpFoundation\Response;

final class VideoPutController extends ApiController
{
    /**
     * @param string $uuid
     * @param Request $request
     * @return Response
     * @throws \JsonException
     */
    public function __invoke(string $uuid, Request $request): Response
    {
        $content = $request->getContent();

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        $this->dispatch(
            new UpsertVideoCommand(
                $uuid,
                $data['user_uuid'],
                $data['name'],
                $data['description'],
                $data['url']
            )
        );

        return new Response(Response::HTTP_OK);
    }
}