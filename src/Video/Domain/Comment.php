<?php
declare(strict_types=1);

namespace Symfony\Base\Video\Domain;

use Symfony\Base\Shared\ValueObject\Date;
use Symfony\Base\Shared\ValueObject\Uuid;

final class Comment
{
    public function __construct
    (       private readonly Uuid $id,
            private readonly Uuid $comment_video_id,
            private readonly Comment $texto,
            private readonly ?Date $created_at = new Date(),
            private readonly ?Date $update_at = null
    )
    {

    }

}