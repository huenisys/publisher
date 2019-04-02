<?php

namespace huenisys\Publisher\Common;

abstract class AbstractExtractor
    implements InterfaceExtractor
{

    /**
     * The type of posting
     * will later identify which
     * props matter
     *
     * @var string
     */
    protected $schemaType;

    /**
     * Identifies the schemaType used for reading file
     * say article, it should identify that MD is to be used
     * as opposed to a product which a csv may be
     * more applicable
     *
     * @return string
     */
    public function getSchemaType()
    {
        return $this->schemaType;
    }

    /**
     * Allows conversion of data from one format to another
     * This uses built-in parsers from this package
     *
     * @param mixed $data
     * @param string|null $conversion
     * @return mixed
     */
    public static function convertData($data, string $conversion = null)
    {
        if (array_key_exists($conversion, self::FORMAT_CONVERSIONS)):
            return $data = self::FORMAT_CONVERSIONS[$conversion]($data);
        else:
            return $data;
        endif;
    }
}
