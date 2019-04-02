<?php

namespace huenisys\Publisher\Normalizer;

use huenisys\Publisher\Common\AbstractValueNormalizer;
use Illuminate\Support\Str;

class Author extends AbstractValueNormalizer
{
    public static function normalizeValue($value)
    {
        $author = Str::title($value);

        // place category in meta
        return [
            'Extras' => [
                'Author' => $author
            ],
            'Schema' => [
                'author' => [
                    'name' => $author
                ]
            ]
        ];
    }
}
