<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\Video\Aplication\DeleteVideo;
use Symfony\Base\Video\Domain\Exceptions\VideoNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class VideoDeleteController
{
    public function __construct(
        private readonly DeleteVideo $useCase
    )
    {
    }

    /**
     * @throws VideoNotFoundException
     */
    public function __invoke(string $id, Request $request): Response
    {
        $this->useCase->__invoke($id);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}