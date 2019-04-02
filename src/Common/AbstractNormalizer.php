<?php

namespace huenisys\Publisher\Common;

abstract class AbstractNormalizer
    implements InterfaceValueNormalizer {

    public static function normalizeValue($value)
    {
        return $value;
    }
}
