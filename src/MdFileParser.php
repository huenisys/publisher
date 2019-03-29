<?php

namespace huenisys\Publisher;

use Illuminate\Support\Facades\File;
use huenisys\Parsers\Yaml;
use huenisys\Parsers\Markdown;

class MdFileParser
{
    protected $rawContentArr;
    protected $data;
    protected $parsedContent;

    public function __construct($filepath_or_content)
    {
        $content = File::exists($filepath_or_content)
            ? File::get($filepath_or_content)
            : $filepath_or_content;
        $this->_splitContent($content);
    }

    public function saveNormalizedData($normalData)
    {
        $this->data = $normalData;
    }

    public function getMetaInYaml()
    {
        return $this->rawContentArr[2];
    }

    public function getMeta(String $key = null)
    {
        $phpArr = Yaml::parse($this->getMetaInYaml());
        if (is_null($key))
            return $phpArr;
        return $phpArr[$key];
    }

    public function getBodyInMd()
    {
        return $this->rawContentArr[3];
    }

    public function getBodyInHtml()
    {
        return Markdown::parse($this->getBodyInMd());
    }

    protected function _splitContent($content)
    {
        dump($content);
        preg_match(
            '/^(`{3}yaml(.*)`{3})?(.*)/s',
            $content,
            $this->rawContentArr
        );
    }
}
