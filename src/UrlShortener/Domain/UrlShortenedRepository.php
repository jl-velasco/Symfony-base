<?php

namespace Symfony\Base\UrlShortener\Domain;

interface UrlShortenedRepository
{
    public function shortenUrl(string $url): string;
}