<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller\HealthCheck;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class UserPutController
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}
