<?php

namespace huenisys\Publisher\Common;

use Illuminate\Support\Str;

trait TraitRawDataNormalizer
{
    abstract public static function array_deep_merge(array &$array1, array &$array2);

    public static $alternateNormalizerNameSpace = "App\\Publisher\\Normalizer\\";

    /**
     * Normalizes raw data from processor
     * with keys that will be validated
     *
     * @param array $rawData
     * @param callable|null $callback
     * @return array
     */
    public static function normalizeData($rawData)
    {
        // go flatter by one level
        // since we expect rawData to have
        $flatterData = array_merge($rawData['meta'], ['body'=>$rawData['body']]);

            dump($flatterData);

        $normalData = [];

        foreach ($flatterData as $k => $v)
        {
            $classSuffix = str_replace(' ','', Str::title($k));

            $defNormalizerClass = "huenisys\\Publisher\\Normalizer\\".$classSuffix;
            $altNormalizerClass = static::$alternateNormalizerNameSpace.$classSuffix;

            if (class_exists($defNormalizerClass)):
                $temp1 = call_user_func_array($defNormalizerClass.'::normalizeValue', [$v]);
                dump('$temp1', $temp1);
                $normalData = array_merge_recursive($normalData, $temp1);
            // alternate
            elseif (class_exists($altNormalizerClass)):
                $temp1 = call_user_func_array($altNormalizerClass.'::normalizeValue', [$v]);
                $normalData = array_merge_recursive($normalData, $temp2);
            // do nothing
            else:
                $normalData[ucfirst($k)] = $v;
            endif;
        }

        return $normalData;
    }
}
