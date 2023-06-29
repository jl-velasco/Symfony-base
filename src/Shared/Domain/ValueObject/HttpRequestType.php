<?php

namespace Symfony\Base\Shared\Domain\ValueObject;

class HttpRequestType extends StringValueObject
{

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    public function __construct(string $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    private function validate(string $type): void
    {
        $allowedTypes = array(self::GET, self::POST, self::PUT, self::PATCH, self::DELETE);
        if (!in_array($type, $allowedTypes)) {
            throw new \InvalidArgumentException('Invalid HTTP request type provided.');
        }
    }
}
