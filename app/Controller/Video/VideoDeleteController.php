<?php

namespace Symfony\Base\App\Controller\Video;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\User\Aplication\DeleteUserUseCase;
use Symfony\Base\User\Domain\Exceptions\UserNotExistException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoDeleteController
{

    public function __construct(
        private readonly DeleteUserUseCase $useCase
    )
    {
    }

    /**
     * @throws UserNotExistException
     * @throws InvalidValueException
     */
    public function __invoke(string $id, Request $request): Response
    {
        $this->useCase->__invoke($id);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
