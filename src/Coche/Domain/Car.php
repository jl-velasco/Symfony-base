<?php

namespace Symfony\Base\Coche\Domain;

class Car
{
    private CarId $carId;
    private array $comments = [];
    private CarLikes $likes;

    public function __construct()
    {
    }

    public function addComment(Comment $comment): void
    {
        $this->comments[] = $comment;
    }

    public function countComments(): int
    {
        return count($this->comments);
    }

    public function addLike(): void
    {
        $this->likes = $this->likes->addLike();
    }

    public function countLikes(): int
    {
        return $this->likes->countLikes();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getComments(): array
    {
        return $this->comments;
    }
}