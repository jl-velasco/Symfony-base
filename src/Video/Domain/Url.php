<?php

declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\Domain\Exception\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\StringValueObject;

final class Url extends StringValueObject
{
    public function __construct(protected string $value)
    {
        parent::__construct($value);
        $this->value = filter_var($value, FILTER_VALIDATE_URL, [
            'options' => array(
                'default' => false,
            ),
        ]);
        if ($this->value === false) {
            throw new InvalidValueException("'{$this->value}' is not a valid URL");
        }
    }
}
