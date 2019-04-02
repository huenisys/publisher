<?php

namespace huenisys\Publisher\Schemas;

use huenisys\Validator\Validator;

use huenisys\Publisher\Interfaces\Schema as SchemaInterface;
use huenisys\Publisher\Interfaces\DataNormalizer as DataNormalizerInterface;
use huenisys\Publisher\Traits\RawDataNormalizer as RawDataNormalizerTrait;

abstract class SchemaAbstract
    implements SchemaInterface, DataNormalizerInterface {

    use RawDataNormalizerTrait;

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
     * @var Array
     */
    public $normalData = [];

    /**
     * Once data is normalized
     * It's time to validate
     *
     * e.g. [title:, slug:, extras: {json}, structuredData: {json}]
     *
     * @var Array
     */
    public $validData = [];

    /**
     * Rules describing reqs by schema
     *
     * @var Array
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

    public function __construct(Interfaces\FileProcessor $processor)
    {
        // normalize the $rawData
        $this->processor = $processor;

        $this->_normalizeRawData(); // prep the needed keyps
        $this->_validateData(); // validate the key values pari
        $this->_saveData(); // save it and store the data
    }

    protected function _normalizeRawData()
    {
        static::normalizeData($this->processor->getRawData(), null);
    }

    public function getProcessorInstance()
    {
        return $this->processor;
    }
}
