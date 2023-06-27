<?php

declare(strict_types=1);

namespace Symfony\Base\Shared\Infrastructure\Mongo;

use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;

class MongoDBDocumentConverter
{
    public static function toArray(mixed $data): mixed
    {
        $converter = [];
        if ($data instanceof BSONDocument || $data instanceof BSONArray || \is_array($data)) {
            foreach ($data as $type => $d) {
                $converter[$type] = self::toArray($d);
            }
        } else {
            return $data;
        }

        return $converter;
    }
}
