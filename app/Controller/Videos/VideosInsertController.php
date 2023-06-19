<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Video\Aplication\DeleteVideoUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class VideosDeleteController
{

    private const REQUIRED_FIELDS = [
        'video_id'
    ];

    public function __construct(
        private readonly DeleteVideoUseCase $useCase
    )
    {
    }

    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $body = $this->getBody($request);
        $this->useCase->__invoke(
            $id,
            $body['video_id']
        );

        return new Response(status: Response::HTTP_NO_CONTENT);
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