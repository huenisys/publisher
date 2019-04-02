<?php

namespace huenisys\Publisher\Common;

interface InterfaceValueNormalizer
{
    /**
     * Pass data
     *
     * @param mixed $data
     * @return array
     */
    static function normalizeValue($data);

    /**
     * Like array merge but
     * respects deep level arrays
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    static function array_deep_merge(array &$array1, array &$array2);
}
