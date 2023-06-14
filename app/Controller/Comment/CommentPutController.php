<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\Comment;

use RuntimeException;
use Symfony\Base\Video\Aplication\UpsertCommentUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CommentPutController
{
    public function __construct(
        private readonly UpsertCommentUseCase $useCase
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $data = $this->dataFromRequest($request);
        $this->useCase->__invoke(
            $id,
            $data['video_id'],
            $data['message'],
        );

        return new Response(status: Response::HTTP_OK);
    }


    /** @return array<string, string> */
    protected function dataFromRequest(Request $request): array
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }

        return $data;
    }
}