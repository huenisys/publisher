<?php

namespace huenisys\Publisher;

class NormalizerTitle extends Common\AbstractNormalizer
{
    public static function normalizeValue($value)
    {
        return ucfirst($value);
    }
}
