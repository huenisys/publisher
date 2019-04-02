<?php

namespace huenisys\Publisher\Tests\Unit;

use PHPUnit\Framework\TestCase;
use huenisys\Publisher\FileReader;

class FileReaderTest
    extends TestCase
{
    protected $file1 = __DIR__.'/../files/file1.md';

    public function setUp() :void
    {
        $this->_processFile1();
    }

    protected function _processFile1()
    {
        $this->fileReader1
            = new FileReader($this->file1);
    }

    /** @test **/
    public function __construct_givenExistingFile_receiveRawData()
    {
        $this->assertNotEmpty($this->fileReader1->getRawData());
    }

    /** @test **/
    public function __construct_givenMissingFile_expectExceptionMessage()
    {
        $this->expectExceptionMessage('File to process:**missingFile.md** is not found.');
        new FileReader('missingFile.md');
    }

    /** @test **/
    public function _getSchemaType_allowChangingConfig()
    {
        $processor = new FileReader($this->file1, ['schemaType'=>'BlogPost']);
        $this->assertEquals('BlogPost', $processor->getSchemaType());
    }

    /** @test **/
    public function getContent_ContentHasEverything()
    {
        $this->assertStringContainsString(
            'title: Hello World',
            $this->fileReader1->getContent());

        $this->assertStringContainsString(
            '# hello world',
            $this->fileReader1->getContent());
    }

    /** @test **/
    public function _getSectionData_metaAndBodyIsSet()
    {
        dump($this->fileReader1);

        $this->assertStringContainsString(
            'title: Hello World',
            $this->fileReader1->getMeta());

        $this->assertStringContainsString(
            '# hello world',
            $this->fileReader1->getBody());
    }

}
