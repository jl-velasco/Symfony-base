<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\User;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\User\Aplication\UpsertUserCommand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use RuntimeException;

final class UserPutController extends ApiController
{
    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $data = $this->dataFromRequest($request);

        $this->dispatch(
            new UpsertUserCommand(
                $id,
                $data['email'],
                $data['name'],
                $data['password'],
            )
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