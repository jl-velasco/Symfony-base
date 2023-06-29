<?php


declare(strict_types=1);

namespace Symfony\Base\Video\Domain;



interface UrlShortServiceRepository
{

    //@todo get Url domain object

    public function get(string $url):string;
}