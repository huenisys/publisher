<?php

namespace huenisys\Publisher\Common;

interface InterfaceDataNormalizer
{
    /**
     * Pass arraw of data and
     * transform into new arraw
     * with desired keys
     *
     * @param Array $data
     * @param callable|null $callback
     * @return Array
     */
    static function normalizeData($data);
}
