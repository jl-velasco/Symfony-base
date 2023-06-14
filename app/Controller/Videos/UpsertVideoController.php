<?php

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Base\Video\Aplication\UpsertVideoUseCase;
use Symfony\Component\HttpFoundation\Response;

class UpsertVideoController
{
    public function __construct(
        private readonly UpsertVideoUseCase $upsertVideoUseCase
    ) {
    }

    public function __invoke(Request $request, string $uuid): Response
    {
        $content = $request->getContent();

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        $this->upsertVideoUseCase->__invoke(
            $uuid,
            $data['user_uuid'],
            $data['name'],
            $data['description'],
            $data['url']
        );

        return new Response(Response::HTTP_CREATED);
    }
}