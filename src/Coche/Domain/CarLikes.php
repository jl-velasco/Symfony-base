<?php

namespace Symfony\Base\Coche\Domain;

class CarLikes
{

    private int $likes;

    public function __construct()
    {

    }

    public function addLike(): self
    {
        return new self($this->likes + 1);
    }

    public function countLikes(): int
    {
        return $this->likes;
    }
}