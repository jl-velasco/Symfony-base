<?php

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\Video\Application\DeleteVideoUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoDeleteController
{
    public function __invoke(Request $request, DeleteVideoUseCase $case): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        $case->__invoke(
            $data['id'] ?? ''
        );

        return new JsonResponse([
            'success' => true
        ],Response::HTTP_CREATED);
    }
}
