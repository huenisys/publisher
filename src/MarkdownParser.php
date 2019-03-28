<?php

namespace huenisys\Blog;

class MarkdownParser
{
    public static function parse($string)
    {
        return \Parsedown::instance()->text($string);
    }
}
