<?php

namespace huenisys\Publisher\Tests;

use Orchestra\Testbench\TestCase;
use huenisys\Publisher\MdFileParser;

class MdFileParserTest extends TestCase
{
    /** @test **/
    public function meta_and_body_gets_split()
    {
        $parsedPost1 = (new MdFileParser(__DIR__.'/../files-in-md/Post1.md'));
        dump($parsedPost1);
        $this->assertStringContainsString('title: Some Title', $parsedPost1->getMetaInYaml());
        $this->assertStringContainsString('This is the body', $parsedPost1->getBodyInMd());
    }

    /** @test **/
    public function get_the_meta_title()
    {
       $parsedPost1 = (new MdFileParser(__DIR__.'/../files-in-md/Post1.md'));
       $this->assertEquals('Some Title', $parsedPost1->getMeta('title'));
    }

    /** @test **/
    public function another_meta_props_check()
    {
       $parsedPost2 = (new MdFileParser(__DIR__.'/../files-in-md/Post2.md'));
       $this->assertEquals('Post2 Title', $parsedPost2->getMeta('title'));
       $this->assertEquals('Garfield', $parsedPost2->getMeta('author'));

       $meta = [
           'title' => 'Post2 Title',
           'author' => 'Garfield',
       ];
       $this->assertEquals($meta, $parsedPost2->getMeta());
    }

    /** @test **/
    public function allow_no_meta()
    {
       $parsedPost3 = (new MdFileParser(__DIR__.'/../files-in-md/Post3-with-no-meta.md'));
       $this->assertEmpty($parsedPost3->getMeta());
       $this->assertStringContainsString('Post with no met', $parsedPost3->getBodyInMd());
    }

    /** @test **/
    public function parse_md_content_only()
    {
       $parsedMdContent = (new MdFileParser('# md content only'));
       $this->assertEquals($parsedMdContent->getBodyInMd(), '# md content only');
       $this->assertEquals($parsedMdContent->getBodyInHtml(), '<h1>md content only</h1>');
    }
}
