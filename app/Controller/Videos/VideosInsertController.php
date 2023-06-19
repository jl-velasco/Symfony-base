<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Video\Aplication\InsertVideoUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class VideosInsertController
{

    public function __construct(
        private readonly InsertVideoUseCase $useCase
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $content = $request->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        $this->useCase->__invoke(
            $id,
            $data['user_uuid'],
            $data['name'],
            $data['description'],
            $data['url']
        );

        return new Response(status: Response::HTTP_CREATED);
    }

}