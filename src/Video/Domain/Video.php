<?php

namespace Symfony\Base\Video\Domain;


use Exception;
use Symfony\Base\Shared\Domain\ValueObject\Date;
use Symfony\Base\Shared\Domain\ValueObject\Description;
use Symfony\Base\Shared\Domain\ValueObject\Name;
use Symfony\Base\Shared\Domain\ValueObject\Url;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;


final class Video
{

    public function __construct(private readonly Uuid        $video_id,
                                private readonly Uuid        $video_user_id,
                                private readonly Name        $name,
                                private readonly Description $description,
                                private readonly Url         $url,
                                private readonly ?Date       $createdAt= new Date(),
                                private readonly ?Date       $updatedAt= null,
                                private ?Comments $comments= new Comments([]),



    ){
    }

public function video() : Uuid{
        return $this->video_id;
}
    public function user() : Uuid
    {
        return $this->video_user_id;
    }

    public function name() : Name
    {
        return $this->name;
    }
    public function description() : Description
    {
        return $this->description;
    }
    public function url() : Url
    {
        return $this->url;
    }
    public function created() : Date
    {
        return $this->createdAt;
    }
    public function updated() : Date
    {
        return $this->updatedAt;
    }
    public function comments(): Comments
    {
        if (!$this->comments) {
            $this->comments = new Comments([]);
        }

        return $this->comments;
    }

}
