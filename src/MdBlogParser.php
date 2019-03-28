<?php

namespace huenisys\Blog;

use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class MdBlogParser
{
    protected $dataArray;

    public function __construct($filepath_or_content)
    {
        $content = File::exists($filepath_or_content)
            ? File::get($filepath_or_content)
            : $filepath_or_content;
        $this->_splitContent($content);
    }

    public function getMetaInYaml()
    {
        return $this->dataArray[2];
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
        return $this->dataArray[3];
    }

    protected function _splitContent($content)
    {
        preg_match(
            '/^(`{3}yaml(.*)`{3})?(.*)/s',
            $content,
            $this->dataArray
        );
    }
}
