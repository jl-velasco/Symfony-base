<?php

namespace Symfony\Base\App\Controller\Videos;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Base\Video\Aplication\UpsertVideoCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Base\Video\Aplication\UpsertVideoCommandHandler;
use Symfony\Component\HttpFoundation\Response;

final class UpsertVideoController extends ApiController
{
    public function __invoke(Request $request, string $uuid): Response
    {
        $content = $request->getContent();

        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        $this->dispatch(
            new UpsertVideoCommand(
                $uuid,
                $data['user_uuid'],
                $data['name'],
                $data['description'],
                $data['url']
            )
        );

        return new Response(Response::HTTP_CREATED);
    }
}