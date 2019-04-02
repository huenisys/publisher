<?php

namespace huenisys\Publisher;

class FileReader extends Common\AbstractExtractor
    implements Common\InterfaceExtractor
{
    const REGEX = '/^(`{3}(yaml)?(.*)`{3})?(.*)/s';
    const SCHEMA_TYPE = 'Article';
    const SECTIONS = [
        'meta' => 3,
        'body' => 4
    ];

    /**
     * Regex for capturing groups
     * e.g. '/^(`{3}(yaml)?(.*)`{3})?(.*)/s'
     *
     * @var string
     */
    protected $regex;

    /**
     * Identifies name of capture groups
     * i.e. meta is at index 3
     * body is at index 4
     *
     * @var array
     */
    protected $sections;

    /**
     * Where captured groups
     * from regex will be stored
     *
     * @var array
     */
    protected $rawData = [];

    /**
     * Subset of rawData
     * but has named sections
     * only
     *
     * @var array
     */
    protected $sectionsData = [];

    protected $filepath; // maybe use file instance for reading mod date?

    /**
     * Process file
     *
     * @param string $filepath
     * @param array $config
     */
    public function __construct($filepath, array $config = [])
    {
        // get folder name as it will be useful when moving or deleting
        $this->filepath = $filepath;

        $config = array_merge([
            'regex' => self::REGEX,
            'sections' => self::SECTIONS,
            'schemaType' => self::SCHEMA_TYPE
        ], $config);

        $this->regex = $config['regex'];
        $this->schemaType = $config['schemaType'];
        $this->sections = $config['sections'];

        $this->_readFile();
        $this->_buildRawData();
    }

    protected function _readFile()
    {
        if (! file_exists($this->filepath))
            throw new \Exception('File to process:**'.$this->filepath.'** is not found.');
    }

    protected function _buildRawData()
    {
        preg_match(
            $this->regex,
            file_get_contents($this->filepath),
            $this->rawData
        );

        // build named sections
        // effectively $rawData['content'] = $rawData[0] etc.
        foreach ($this->sections as $sectionName => $index)
        {
            $this->sectionsData[$sectionName]
                // remove trailing whitespace
                = trim($this->rawData[$index]);
        }
    }

    /**
     * All content from processed file
     * no section returns the entire regex
     * output plus the named duplicates
     *
     * @param number|null $regexIndex
     * @return string|null
     */
    public function getRawData($regexIndex = null)
    {
        $rawData = is_null($regexIndex)
            ? $this->rawData
            : ($this->rawData[$regexIndex] ?? null);

        return $rawData;
    }

    /**
     * The entire content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->rawData[0];
    }

    /**
     * Subset of rawData but gets the named sections
     * only, i.e. whats important trailing spaces
     * were trimmed already
     *
     * @param string|null $sectionName
     * @param string|null $conversion
     * @return mixed|null
     */
    public function getSectionData($sectionName = null, $conversion = null)
    {
        $data = is_null($sectionName)
            ? $this->sectionsData
            : ($this->sectionsData[$sectionName] ?? null);

        $data = static::convertData($data, $conversion);

        return $data;
    }

    /**
     * The sub attributes for extracted data
     *
     * @param string|null $conversion
     * @return string
     */
    public function getMeta($conversion = null)
    {
        return $this->getSectionData('meta', $conversion);
    }

    /**
     * The sub attributes for extracted data
     *
     * @param string|null $conversion
     * @return string
     */
    public function getBody($conversion = null)
    {
        return $this->getSectionData('body');
    }


}
