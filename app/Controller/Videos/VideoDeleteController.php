<?php

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\Video\Aplication\DeleteVideoCommand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class VideoDeleteController extends ApiController
{

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $this->dispatch(
            new DeleteVideoCommand($id)
        );

        return new Response(status: Response::HTTP_NO_CONTENT);
    }

}