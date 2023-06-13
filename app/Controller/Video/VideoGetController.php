<?php

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\Video\Aplication\GetVideoUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoGetController
{

    public function __construct(
        private readonly GetVideoUseCase $getVideoUseCase
    )
    {
    }

    public function __invoke(Request $request, string $id): Response
    {
        return new JsonResponse($this->getVideoUseCase->__invoke($id)->toArray());
    }
}
