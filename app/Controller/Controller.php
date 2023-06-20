<?php

namespace Symfony\Base\App\Controller;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
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
