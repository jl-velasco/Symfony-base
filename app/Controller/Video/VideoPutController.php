<?php

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\App\Controller\Controller;
use Symfony\Base\Video\Application\UpsertVideoUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class VideoPutController extends Controller
{
    protected const REQUIRED_FIELDS = [
        'name',
        'url',
        'userId',
    ];


    public function __construct(
        private readonly UpsertVideoUseCase $useCase
    )
    {
    }

    public function __invoke(string $id, Request $request): Response
    {
        $data = $this->dataFromRequest($request);

        $this->useCase->__invoke(
            $id,
            $data['userId'],
            $data['name'],
            $data['description'] ?? '',
            $data['url']
        );

        return new Response(status: Response::HTTP_OK);
    }
}
