<?php

namespace Symfony\Base\Video\Dominio;


use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\Url;
use Symfony\Base\Shared\ValueObject\Uuid;


final class Video
{

    public function __construct(private readonly Uuid $video_id,
                                private readonly Uuid $video_user_id,
                                private readonly Name $name,
                                private readonly Description $description,
                                private readonly Url $url,
                                private readonly Date $created_at,
                                private readonly Date $updated_at


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
        return $this->created_at;
    }
    public function updated() : Date
    {
        return $this->updated_at;
    }
}
