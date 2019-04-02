<?php

namespace huenisys\Publisher\Common;

use huenisys\Validator\Validator;
use huenisys\Parsers\Yaml;

abstract class AbstractSchema
    implements InterfaceSchema, InterfaceDataNormalizer {

    use TraitRawDataNormalizer, TraitArrayDeepMerge;

    /**
     * Processor instance who started this
     *
     * @var Interfaces\FileProcessor;
     */
    protected $processor;

    /**
     * Raw data transformed to one-level
     * array with keys to be saved in the
     * database
     *
     * e.g. [title:, slug:, extras: {json}, structuredData: {json}]
     *
     * @var array
     */
    public $normalData = [];

    /**
     * Once data is normalized
     * It's time to validate
     *
     * e.g. [title:, slug:, extras: {json}, structuredData: {json}]
     *
     * @var array
     */
    public $validData = [];

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

    public function __construct(InterfaceFileProcessor $processor)
    {
        // normalize the $rawData
        $this->processor = $processor;

        $this->_normalizeRawData(); // prep the needed keyps
        $this->_validateData(); // validate the key values pari
        $this->_saveData(); // save it and store the data
    }

    protected function _normalizeRawData()
    {
        $data = [
            'meta' => Yaml::parse($this->processor->getRawData('meta')),
            'body' => $this->processor->getRawData('body')
        ];

        static::normalizeData($data, null);
    }

    public function getProcessorInstance()
    {
        return $this->processor;
    }
}
