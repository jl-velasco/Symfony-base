<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\Uuid;

interface VideoRepository
{
    public function save(Video $video): Video;

    public function search(Uuid $id): Video|null;

    public function delete(Uuid $id): void;
}
