<?php

namespace huenisys\Blog\Tests\Feature;

use Orchestra\Testbench\TestCase;
use huenisys\Blog\MdBlogParser;

class MdBlogParserTest extends TestCase
{
    /** @test **/
    public function meta_and_body_gets_split()
    {
        $parsedPost1 = (new MdBlogParser(__DIR__.'/../blog-files-in-md/Post1.md'));
        $this->assertStringContainsString('title: Some Title', $parsedPost1->getMetaInYaml());
        $this->assertStringContainsString('This is the body', $parsedPost1->getBodyInMd());
    }

    /** @test **/
    public function get_the_meta_title()
    {
       $parsedPost1 = (new MdBlogParser(__DIR__.'/../blog-files-in-md/Post1.md'));
       $this->assertEquals('Some Title', $parsedPost1->getMeta('title'));
    }

    /** @test **/
    public function another_meta_props_check()
    {
       $parsedPost2 = (new MdBlogParser(__DIR__.'/../blog-files-in-md/Post2.md'));
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
       $parsedPost3 = (new MdBlogParser(__DIR__.'/../blog-files-in-md/Post3-with-no-meta.md'));
       $this->assertEmpty($parsedPost3->getMeta());
       $this->assertStringContainsString('Post with no met', $parsedPost3->getBodyInMd());
    }
}
