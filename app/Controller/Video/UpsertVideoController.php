<?php

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Base\Video\Aplication\UpsertVideoUseCase;
use Symfony\Component\HttpFoundation\Response;

class UpsertVideoController
{
    public function __construct(
        private readonly UpsertVideoUseCase $upSertVideoUseCase
    ) {
    }

    /**
     * @throws \JsonException
     * @throws InvalidValueException
     */
    public function __invoke(string $uuid, Request $request): Response
    {
        $content = $request->getContent();

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        $this->upSertVideoUseCase->__invoke(
            $uuid,
            $data['user_uuid'],
            $data['name'],
            $data['description'],
            $data['url']
        );

        return new Response(Response::HTTP_CREATED);
    }
}
