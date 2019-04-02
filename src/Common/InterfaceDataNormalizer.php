<?php

namespace huenisys\Publisher\Common;

interface InterfaceDataNormalizer
{
    /**
     * Pass arraw of data and
     * transform into new arraw
     * with desired keys
     *
     * @param array $data
     * @param callable|null $callback
     * @return array
     */
    static function normalizeData($data);
}
