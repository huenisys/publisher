<?php

namespace huenisys\Publisher\Normalizers;

use huenisys\Publisher\Interfaces\ValueNormalizer as ValueNormalizerInterface;

abstract class NormalizerAbstract
    implements ValueNormalizerInterface {

    public static function normalizeValue($value)
    {
        return $value;
    }
}
