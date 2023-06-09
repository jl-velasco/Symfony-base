<?php
declare(strict_types=1);

namespace Symfony\Base\Comments\Dominio;

use Symfony\Base\Shared\ValueObject\Uuid;

interface CommentsRepositoryInterface
{
    public function save(Comments $comments): void;

    public function search(Uuid $id): Comments;

    public function delete(Uuid $id, bool $flush): void;
}
