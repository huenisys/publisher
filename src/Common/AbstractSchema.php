<?php

namespace huenisys\Publisher\Common;

use huenisys\Validator\Validator;
use huenisys\Parsers\Yaml;

abstract class AbstractSchema
    implements InterfaceSchema, InterfaceDataNormalizer {

    use TraitRawDataNormalizer, TraitArrayDeepMerge;

    /**
     * Schema Type
     *
     * @var string
     */
    protected $type = 'Article';

    /**
     * Stores meta and body in markdown
     *
     * @var array
     */
    protected $data;

    /**
     * Raw data transformed to one-level
     * array with keys to be saved in the
     * database
     *
     * e.g. [title:, slug:, extras: {json}, structuredData: {json}]
     *
     * @var array
     */
    protected $normalData = [];

    /**
     * Once data is normalized
     * It's time to validate
     *
     * e.g. [title:, slug:, extras: {json}, structuredData: {json}]
     *
     * @var array
     */
    protected $validData = [];

    /**
     * Rules describing reqs by schema
     *
     * @var array
     */
    public $schemaRules = [
        'id' => 'numeric',
        'hash' => 'alnum',
        'title' => 'length:null,100',
        'slug' => 'slug',
        'extras' => 'json',
        'jsonLd' => 'json', //structured data
    ];

    // save rules?
    // model rules?
    // repository rules?
    public $saveRules = [
        'id' => 'unique',
        'hash' => 'unique',
        'title' => 'unique',
    ];

    /**
     * Eloquent
     *
     * @var mixed
     */
    public $modelData = [];

    protected function _validateData(){}
    protected function _saveData(){}

    public function getType()
    {
        return $this->type;
    }

    /**
     * Eloquent
     *
     * @param array $rawData
     */
    public function __construct(array $rawData)
    {
        $this->data = [
            'meta' => Yaml::parse($rawData['meta']),
            'body' => $rawData['body']
        ];

        $this->_normalizeRawData(); // prep the needed keyps
        $this->_validateData(); // validate the key values pari
        $this->_saveData(); // save it and store the data
    }

    protected function _normalizeRawData()
    {
        static::normalizeData($this->data, null);
    }
}
