<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller\Videos;

use JsonException;
use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Video\Aplication\InsertCommentCommand;
use Symfony\Base\Video\Aplication\InsertCommentCommandHandler;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class InsertCommentController extends ApiController
{
    private const REQUIRED_FIELDS = [
        'video_id',
        'message',
    ];

    /**
     * @throws JsonException|InvalidValueException|VideoNotFoundException
     */
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $body = $this->getBody($request);
        $this->dispatch(
            new InsertCommentCommand(
                $id,
                $body['video_id'],
                $body['message']
            )
        );

        return new JsonResponse([], Response::HTTP_CREATED);
    }

    /**
     * @return array<string, mixed>
     * @throws InvalidValueException|JsonException
     */
    public function getBody(Request $request): array
    {
        $body = json_decode(
            json: $request->getContent(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!isset($body[$field])) {
                throw new InvalidValueException("Field '$field' cannot be null");
            }
        }
        return $body;
    }
}