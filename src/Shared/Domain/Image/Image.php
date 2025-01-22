<?php

namespace Symfony\Base\Shared\Domain\Image;

use Symfony\Base\Order\ImageSize;
use Symfony\Base\Order\ImageType;

class Image
{
    public function __construct(
        private ImageName $name,
        private ImageType $type,
        private ImageSize $size,
        private ImageContent $content
    )
    {
    }

    public function dimensions()
    {
        $info = @getimagesizefromstring($this->content->value());
        if ($info !== false) {
            return [
                'width' => $info[0],
                'height' => $info[1]
            ];
        }
    }

    public function size(): int
    {
        return $this->size->value();
    }
}