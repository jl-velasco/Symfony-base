<?php

namespace Symfony\Base\App\Controller\Video\Video;

use Symfony\Base\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Base\Video\Video\Application\GetVideoQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetVideoController
{
    public function __construct(
        private QueryBus $queryBus,
    )
    {
    }

    public function __invoke(
        Request  $request,
        string $id
    ): Response
    {
        $response = $this->queryBus->ask(
            new GetVideoQuery($id)
        );

        return new Response($response->toPrimitives(), Response::HTTP_ACCEPTED);
    }
}