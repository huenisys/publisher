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

    /**
     * @var FileReader;
     */
    public $fileReader;

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
        $this->fileReader = new FileReader($filepath, $config);

        $this->_runSchemaProcedures();
    }

    protected function _runSchemaProcedures()
    {
        $defSchemaClass = self::DEFAULT_SCHEMA_NAMESPACE . $this->fileReader->getSchemaType();
        $altSchemaClass = static::$altSchemaNamespace . $this->fileReader->getSchemaType();

        $rawData = $this->fileReader->getSectionData();

        if (class_exists($defSchemaClass)):
            $this->schema = new $defSchemaClass($rawData);
        // alternate
        elseif (class_exists($altSchemaClass)):
            $this->schema = new $altSchemaClass($rawData);
        else:
            $this->schema = new static::$fallbackSchemaClass($rawData);
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
        return $this->fileReader->getSectionData($sectionName);
    }

}
