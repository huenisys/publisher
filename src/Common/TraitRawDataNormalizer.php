<?php

namespace huenisys\Publisher\Common;

use Illuminate\Support\Str;

trait TraitRawDataNormalizer
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
        $normalData = [];

        // go flatter by one level
        // since we expect rawData to have
        $flatterData = array_merge($rawData['meta'], ['body'=>$rawData['body']]);

        foreach ($flatterData as $k => $v)
        {
            $classSuffix = str_replace(' ','', Str::title($k));

            $defNormalizerClass = 'huenisys\Publisher\Normalizer'.$classSuffix;
            $altNormalizerClass = 'App\Publisher\Normalizer'.$classSuffix;

            switch (true) {
                // first choice
                case class_exists($defNormalizerClass) :

                    call_user_func_array($defNormalizerClass.'::normalizeValue', [$v]);
                    break;

                // alternate
                case class_exists($altNormalizerClass) :
                    call_user_func_array($altNormalizerClass.'::normalizeValue', [$v]);
                    break;

                // do nothing
                default:
                    $normalData[$k] = [$v];
            }

            // allow replacement

/*
            if(class_exists($normalizerClass)){
                $normalData[$k]
                    = call_user_func_array($defaultNormalizerClass.'::normalizeValue', [$v]);
            }
*/
        }

        // do something on raw so it will be normal
        return $normalData;
    }
}
