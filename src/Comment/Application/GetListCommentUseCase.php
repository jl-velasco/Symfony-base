<?php
declare(strict_types=1);

namespace Symfony\Base\Comment\Application;

use Symfony\Base\Comment\Domain\CommentRepository;
use Symfony\Base\Shared\Domain\Collection;
use Symfony\Base\Shared\Domain\Exceptions\InvalidValueException;
use Symfony\Base\Shared\Domain\ValueObject\Uuid;

class GetListCommentUseCase
{
    public function __construct(
        private readonly CommentRepository $repository
    )
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function __invoke(
        string $videoId
    ): CommentListResponse
    {
        return new CommentListResponse($this->repository->getByVideo(
            new Uuid($videoId)
        ));
    }


}
