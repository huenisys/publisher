<?php

namespace huenisys\Blog\Tests\Feature;

use Orchestra\Testbench\TestCase;
use huenisys\Blog\MarkdownParser;

class MarkdownParserTest extends TestCase
{
    /** @test **/
    public function simple_md_is_parsed()
    {
        $this->assertEquals(MarkdownParser::parse('# hello'), '<h1>hello</h1>');
    }
}
