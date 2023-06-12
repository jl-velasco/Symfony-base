<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Dominio;

use Symfony\Base\Shared\ValueObject\Description;

class VideoDescription extends Description
{
    private const DEF_MAX_LENGTH = 1000;

    public function __construct(private string $description = '')
    {
        parent::__construct($this->value());
        $this->validate();
    }

    private function validate(): void
    {
        if (mb_strlen($this->description) > self::DEF_MAX_LENGTH) {
            throw new \Exception('Field limit exceeded.');
        }
    }
}