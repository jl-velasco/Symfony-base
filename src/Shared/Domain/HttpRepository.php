<?php

namespace Symfony\Base\Shared\Domain;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface HttpRepository
{
    public function request(string $method, string $url, array $options = []): ResponseInterface;
}