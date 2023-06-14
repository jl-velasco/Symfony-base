<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Aplication;

use Symfony\Base\Shared\Domain\ValueObject\Date;


final class VideoResponse
{
    public function __construct(
        private readonly string $video_id,
        private readonly string $video_user_id,
        private readonly string $name,
        private readonly string $description,
        private readonly string $url,
        private readonly ?Date       $created_at= new Date(),
        private readonly ?Date       $updated_at= new  Date()


    )
    {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'video_id' => $this->video_id,
            'video_user_id'=> $this->video_user_id,
            'name' => $this->name,
            'description'=>$this->description,
            'url'=>$this->url,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at


        ];


    }
}
