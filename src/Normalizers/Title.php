<?php

namespace huenisys\Publisher\Normalizers;

class Title extends NormalizerAbstract
{
    public static function normalizeValue($value)
    {
        return ucfirst($value);
    }
}
