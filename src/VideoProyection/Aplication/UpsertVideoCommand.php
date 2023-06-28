<?php
declare(strict_types=1);

namespace Symfony\Base\VideoProyection\Aplication;

use Symfony\Base\Shared\Domain\Bus\Command\Command;

class UpsertVideoCommand implements Command
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $userUuid,
        private readonly string $name,
        private readonly string $description,
        private readonly string $url
    )
    {

    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function url(): string
    {
        return $this->url;
    }
}