<?php

namespace huenisys\Publisher\Traits;

use Illuminate\Support\Str;

trait RawDataNormalizer
{
    /**
     * Normalizes raw data from processor
     * with keys that will be validated
     *
     * @param Array $rawData
     * @param callable|null $callback
     * @return Array
     */
    public static function normalizeData($rawData)
    {
        // go flatter by one level
        $normalData = array_merge($rawData['meta'], ['body'=>$rawData['body']]);

        $namespace = 'huenisys\\Publisher\\Normalizers\\';

        foreach ($normalData as $k => $v)
        {
            $normalizerClass = $namespace
                . str_replace(' ','', Str::title($k));

            if(class_exists($normalizerClass)){

                $normalData[$k]
                    = call_user_func_array($normalizerClass.'::normalizeValue', [$v]);
            }
        }

        dump($normalData);

        // do something on raw so it will be normal
        return $normalData;
    }
}
