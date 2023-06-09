<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Dominio;



use Symfony\Base\Shared\ValueObject\Uuid;

interface VideoRepository
{
    public function save(Video $video):void;

    public function search(Uuid $uuid):Video;
    public function delete(Uuid $uuid): void;

}