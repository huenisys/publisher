<?php

namespace huenisys\Publisher;

use Illuminate\Support\Arr;

class Config {

    /**
     * The type of posting
     * e.g. Article
     *
     * @var string
     */
    public $schema = 'Article';

    /**
     * Regex for capturing groups
     * e.g. '/^(`{3}(yaml)?(.*)`{3})?(.*)/s'
     *
     * @var string
     */
    public $regex = '/^(`{3}(yaml)?(.*)`{3})?(.*)/s';

    /**
     * Identifies name of capture groups
     * i.e. index 0 is 'content' by default
     * meta is at index 3
     * body is at index 4
     *
     * @var array
     */
    public $sections = [
        'content' => 0,
        'meta' => 3,
        'body' => 4
    ];

    public function __construct(Array $config = [])
    {
        $whitelist
            = Arr::only($config, [
                'schema',
                'regex',
                'sections']);

        foreach ($whitelist as $configKey => $configVal)
            $this->$configKey = $configVal;
    }
}
