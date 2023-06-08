<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\Uuid;

interface VideoRepository
{
    public function save(Video $user): void;

    public function search(Uuid $id): Video;

    public function delete(Uuid $id): void;
}
