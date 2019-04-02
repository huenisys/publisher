<?php

namespace huenisys\Publisher\Common;

/**
 * Allows fetching data to be consumed somewhere
 */
interface InterfaceExtractor
{
    /**
     * Maps file formats to supported parser
     *
     */
    const FORMAT_CONVERSIONS = [
        'md>html' => 'huenisys\Parsers\Markdown::parse',
        'yaml>php' => 'huenisys\Parsers\Yaml::parse'
    ];

    /**
     * Returns the main content of an object
     * For an article, it will be the markdown
     * For a product, csv most likely
     *
     * @param string $conversion
     * @return mixed
     */
    public function getBody($conversion = null);

    /**
     * Returns the meta info of an object
     *
     * @param string $conversion
     * @return mixed
     */
    public function getMeta($conversion = null);

    /**
     * Returns the full content of file
     *
     * @return mixed
     */
    public function getContent();

    /**
     * Allows conversion of data from one format to another
     * This uses built-in parsers from this package
     *
     * @param mixed $data
     * @param string|null $conversion
     * @return mixed
     */
    public static function convertData($data, string $conversion = null);

    /**
     * Returns the schema type
     *
     * @return mixed
     */
    public function getSchemaType();
}
