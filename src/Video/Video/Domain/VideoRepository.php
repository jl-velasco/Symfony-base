<?php

namespace Symfony\Base\Video\Video\Domain;

interface VideoRepository
{
    public function save(Video $video): void;

    public function search(VideoId $id): ?Video;

    public function delete(VideoId $id): void;
}