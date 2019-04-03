<?php

namespace huenisys\Publisher\Tests\Unit;

use PHPUnit\Framework\TestCase;
use huenisys\Publisher\MdFileProcessor;

class MdFileProcessorTest
    extends TestCase
{
    protected $file1 = __DIR__.'/../files/file1.md';

    public function setUp() :void
    {
        $this->_processFile1();
    }

    protected function _processFile1()
    {
        $this->file1Processor
            = new MdFileProcessor($this->file1);
    }

    /** @test **/
    public function _runSchemaProcedures_verifySchemaObjectCreated()
    {
        //$this->assertInternalType()
        $this->assertInstanceOf(
            'huenisys\Publisher\Common\InterfaceSchema',
            $this->file1Processor->getSchemaInstance()
            );

        dump($this->file1Processor);
    }

}
