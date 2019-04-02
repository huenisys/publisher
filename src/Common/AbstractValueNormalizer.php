<?php

namespace huenisys\Publisher\Common;

abstract class AbstractValueNormalizer
implements InterfaceValueNormalizer {

    use TraitArrayDeepMerge;

    /**
     * Pass arraw of data and
     * transform into new arraw
     * with desired keys
     *
     * @param mixed $data
     * @return array
     */
    public static function normalizeValue($value)
    {
        return [
            'key' => $value
        ];
    }
}
