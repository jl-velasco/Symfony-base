<?php

namespace Symfony\Base\VideoList\Domain;

Interface ShorterUrlRepository
{

    public function shortUrl(string $url): string;

}