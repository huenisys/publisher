<?php

namespace huenisys\Publisher\Normalizer;

use huenisys\Publisher\Common\AbstractValueNormalizer;

class Category extends AbstractValueNormalizer
{
    public static function normalizeValue($value)
    {
        // place category in meta
        return [
            'Extras' => [
                'Category' => ucfirst($value)
            ]
        ];
    }
}
