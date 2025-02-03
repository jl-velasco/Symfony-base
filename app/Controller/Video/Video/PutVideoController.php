<?php

namespace Symfony\Base\App\Controller\Video\Video;

use Symfony\Base\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Base\Video\Video\Application\DTOVideo;
use Symfony\Base\Video\Video\Application\UpdateVideoCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutVideoController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    )
    {
    }

    /**
     * @throws \JsonException
     */
    public function __invoke(
        Request  $request,
        string $id
    ): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->commandBus->dispatch(
            new UpdateVideoCommand(
                $id,
                $data['user_id'],
                $data['name'],
                $data['description'],
                $data['url']
            )
        );

        return new Response(status: Response::HTTP_ACCEPTED);
    }
}