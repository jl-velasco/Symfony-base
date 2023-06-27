<?php
declare(strict_types=1);

namespace Symfony\Base\App\Controller\User;

use Symfony\Base\App\Controller\ApiController;
use Symfony\Base\Registater\Aplication\DeleteUserCommand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class UserDeleteController extends ApiController
{
    /** @throws \JsonException */
    public function __invoke(string $id, Request $request): Response
    {
        $this->dispatch(new DeleteUserCommand($id));

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}