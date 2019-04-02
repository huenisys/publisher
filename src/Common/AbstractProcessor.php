<?php

namespace huenisys\Publisher\Common;

use huenisys\Publisher\Config;

abstract class AbstractProcessor
    implements InterfaceFileProcessor
{

    /**
     * Instance of Schema
     *
     * @var Interfaces\Schema
     */
    protected $schema;

    /**
     * configuration
     *
     * @var Config
     */
    public $config;

    /**
     * Path to file
     *
     * @var string
     */
    public $filepath;

    /**
     * Used as output for preg_match
     *
     * @var array
     */
    private $rawData = [];

    /**
     * Data that will be used to create a model
     *
     * @var array
     */
    public $normalData = [];

    /**
     * Process file
     *
     * @param string $filepath
     * @param array $config
     */
    public function __construct($filepath, Array $config = [])
    {
        $this->filepath = $filepath;

        $this->_configure(new Config($config));

        $this->_fileCheck();

        $this->_buildRawData();

        $this->_runSchemaProcedures();

        // schemaCheck it
        // when schema is done, it's saved in db
        // export it
    }

    protected function _configure(Config $config)
    {
        $this->config = $config;
    }

    protected function _fileCheck()
    {
        if (! file_exists($this->filepath))
            throw new \Exception('File to process is not found.');
    }

    protected function _buildRawData()
    {
        preg_match(
            $this->config->regex,
            file_get_contents($this->filepath),
            $this->rawData
        );

        // build named sections
        // effectively $rawData['content'] = $rawData[0] etc.
        foreach ($this->config->sections as $sectionName => $index)
        {
            $this->rawData[$sectionName]
                // remove trailing whitespace
                = trim($this->rawData[$index]);
        }
    }

    protected function _runSchemaProcedures()
    {

        $schemaClass = 'huenisys\Publisher\Schema'
            . $this->config->schema;

        if (class_exists($schemaClass))
            $this->schema = new $schemaClass($this);
        // else throw error
    }

    /**
     * All content from processed file
     *
     * @param string|null $sectionName
     * @param string|null $format
     */
    public function getRawData($sectionName = null, $format = null)
    {
        $rawData = is_null($sectionName)
            ? $this->rawData
            : $this->rawData[$sectionName];

        return $rawData;
    }

    public function getSchemaInstance()
    {
        return $this->schema;
    }

}
