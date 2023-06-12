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
        private readonly ?Date $created_at = new Date(),
        private readonly ?Date $update_at = null
    )
    {

    }
    public function Id(): Uuid
    {
        return $this->id;
    }

    public function Video_User_Id(): Uuid
    {
        return $this->video_user_id;
    }

    public function Name(): Name
    {
        return $this->name;
    }

    public function Description(): Description
    {
        return $this->description;
    }

    public function Url(): URL
    {
        return $this->url;
    }

    public function Created_At(): ?Date
    {
        return $this->created_at;
    }

    public function Update_At(): ?Date
    {
        return $this->update_at;
    }
}
?>