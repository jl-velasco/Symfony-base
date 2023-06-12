<?php

namespace Symfony\Base\Video\Dominio;

use Symfony\Base\Shared\ValueObject\Uuid;



interface VideoRepository
{
    public function save(Video $video): void;

    public function search(Uuid $id): Video;
    public function delete(Uuid $id): void;
}
