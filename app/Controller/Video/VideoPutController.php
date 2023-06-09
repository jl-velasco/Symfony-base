<?php

declare(strict_types=1);

namespace Symfony\Base\App\Controller\HealthCheck;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class VideoPutController
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}
