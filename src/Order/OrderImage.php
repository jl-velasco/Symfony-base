<?php

namespace Symfony\Base\Order;

class OrderImage
{
    public function __construct(
        private OrderImageName $name,
        private OrderImageType $type,
        private OrderImageSize $size,
        private OrderImageContent $content
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