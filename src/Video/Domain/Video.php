<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Description;
use Symfony\Base\Shared\ValueObject\Name;
use Symfony\Base\Shared\ValueObject\URL;
use Symfony\Base\Shared\ValueObject\Uuid;



final class Video
{
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $video_user_id,
        private readonly Name $name,
        private readonly Description $description,
        private readonly URL $url,
        private readonly Date $created_at,
        private readonly Date $update_id
    )
    {

    }
    public function id(): Uuid
    {
        return $this->id;
    }

    public function video_user_id(): Uuid
    {
        return $this->video_user_id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function description(): Description
    {
        return $this->description;
    }

    public function url(): URL
    {
        return $this->url;
    }

    public function created_at(): Date
    {
        return $this->created_at;
    }

    public function update_id(): Date
    {
        return $this->update_id;
    }

}
?>