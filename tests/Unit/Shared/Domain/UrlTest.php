<?php
declare(strict_types = 1);

namespace Symfony\Base\Tests\Unit\Shared\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Base\Shared\Domain\ValueObject\Url;

class UrlTest extends TestCase
{
    public function testUrlShouldOk(): void
    {
        $value = 'http://www.google.com';
        $url = new Url($value);
        $this->assertEquals($value, $url->value());
    }

    public function testUrlShouldKo(): void
    {
        $value = 'www.google.com';
        $this->expectException(InvalidArgumentException::class);
        new Url($value);
    }
}