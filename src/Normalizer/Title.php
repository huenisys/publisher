<?php

namespace huenisys\Publisher\Normalizer;

use huenisys\Publisher\Common\AbstractValueNormalizer;

class Title extends AbstractValueNormalizer
{
    public static function normalizeValue($value)
    {
        return [
            'Title' => ucfirst($value)
        ];
    }
}
