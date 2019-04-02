<?php

namespace huenisys\Publisher\Tests\Unit;

use PHPUnit\Framework\TestCase;
use huenisys\Publisher\ProcessorMdFile;

class ProcessorMdFileTest
    extends TestCase
{
    protected $file1 = __DIR__.'/../../test-files/file1.md';

    public function setUp() :void
    {
        $this->_processFile1();
    }

    protected function _processFile1()
    {
        $this->file1Processor
            = new ProcessorMdFile($this->file1);
    }

    /** @test **/
    public function __construct_givenExistingFile_receiveRawData()
    {
        $this->assertNotEmpty($this->file1Processor->getRawData());
    }

    /** @test **/
    public function _configure_allowChangingConfig()
    {
        $processor = new ProcessorMdFile($this->file1, ['schema'=>'BlogPost']);
        $this->assertEquals('BlogPost', $processor->config->schema);
    }

    /** @test **/
    public function _fileCheck_givenMissingFile_expectExceptionMessage()
    {
        $this->expectExceptionMessage('File to process is not found.');
        new ProcessorMdFile('missingFile.md');
    }

    /** @test **/
    public function _buildRawData_ContentHasEverything()
    {
        $this->assertStringContainsString(
            'title: Hello World',
            $this->file1Processor->getRawData('content'));

        $this->assertStringContainsString(
            '# hello world',
            $this->file1Processor->getRawData('content'));
    }

    /** @test **/
    public function _buildRawData_metaAndBodyIsSet()
    {
        $this->assertStringContainsString(
            'title: Hello World',
            $this->file1Processor->getRawData('meta'));

        $this->assertStringContainsString(
            '# hello world',
            $this->file1Processor->getRawData('body'));
    }

    /** @test **/
    public function _runSchemaProcedures_verifyObjects()
    {
        $this->assertEquals(
            $this->file1Processor,
            $this->file1Processor
                ->getSchemaInstance()->getProcessorInstance()
        );
    }

}
