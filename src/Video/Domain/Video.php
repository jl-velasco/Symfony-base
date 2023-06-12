<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Dominio;


use Symfony\Base\Shared\ValueObject\CreatedAt;
use Symfony\Base\Shared\ValueObject\UpdatedAt;
use Symfony\Base\Shared\ValueObject\Uuid;
use Symfony\Base\Shared\ValueObject\VideoDescription;
use Symfony\Base\Shared\ValueObject\VideoName;
use Symfony\Base\Shared\ValueObject\VideoUrl;
use Symfony\Base\Shared\ValueObject\Date;

class Video
{


    public function __construct(
        private readonly Uuid             $id,
        private readonly Uuid             $user_id,//@todo eval ¿should be a specific value object?
        private readonly VideoName        $name,
        private readonly VideoDescription $description,
        private readonly VideoUrl         $url,
        private readonly ?Date $created_at = new Date(),
        private readonly ?Date $updated_at = null
    )
    {
    }

    /**
     * @return Uuid
     */
    public function id(): Uuid
    {
        return $this->id;
    }

    /**
     * @return Uuid
     */
    public function userId(): Uuid
    {
        return $this->user_id;
    }

    /**
     * @return VideoName
     */
    public function name(): VideoName
    {
        return $this->name;
    }

    /**
     * @return VideoDescription
     */
    public function description(): VideoDescription
    {
        return $this->description;
    }

    /**
     * @return VideoUrl
     */
    public function url(): VideoUrl
    {
        return $this->url;
    }

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->created_at;
    }

    /**
     * @return UpdatedAt
     */
    public function updatedAt(): UpdatedAt
    {
        return $this->updated_at;
    }


}
