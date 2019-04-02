<?php

namespace huenisys\Publisher\Common;

interface InterfaceValueNormalizer
{
    /**
     * Pass arraw of data and
     * transform into new arraw
     * with desired keys
     *
     * @param mixed $data
     * @return mixed
     */
    static function normalizeValue($data);
}
