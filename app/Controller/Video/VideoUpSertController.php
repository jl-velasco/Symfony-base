<?php

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Video\Application\UpsertVideoUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoUpSertController
{
    public function __invoke(Request $request, UpsertVideoUseCase $case): Response
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        $video = $case->__invoke(
            $data['id'] ?? Uuid::random(),
            $data['userId'] ?? '',
            $data['name'] ?? '',
            $data['description'] ?? '',
            $data['url'] ?? ''
        );

        return new JsonResponse($video,Response::HTTP_CREATED);
    }
}
