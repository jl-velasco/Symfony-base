<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Name as BaseName;

class Name extends BaseName
{
    /**
     * @throws InvalidValueException
     */
    public function __construct(protected string $value = '')
    {
        parent::__construct($value);
        if (!preg_match('/^[\x00-\x7F]*$/', $this->value)) {
            throw new InvalidValueException("'{$this->value}' contains invalid characters");
        }
    }
}
