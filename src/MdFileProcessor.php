<?php

namespace huenisys\Publisher;

use huenisys\Publisher\Config;
use huenisys\Publisher\Schema\Article;

class MdFileProcessor
    implements Common\InterfaceProcessor
{
    use Common\TraitProcessorConfigurables;

    /**
     * Instance of Schema dynamically create when a
     * processor runs based on the schema set
     * in the constructor config
     *
     * @var Common\InterfaceSchema
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

    public function getSchemaInstance()
    {
        return $this->schema;
    }

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
        $defSchemaClass = self::DEFAULT_SCHEMA_NAMESPACE . $this->config->schema;
        $altSchemaClass = static::$altSchemaNamespace . $this->config->schema;

        if (class_exists($defSchemaClass)):
            $this->schema = new $defSchemaClass($this->rawData);
        // alternate
        elseif (class_exists($altSchemaClass)):
            $this->schema = new $altSchemaClass($this->rawData);
        else:
            $this->schema = new static::$fallbackSchemaClass($this->rawData);
        endif;
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

}
