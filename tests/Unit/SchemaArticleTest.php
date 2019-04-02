<?php

namespace huenisys\Publisher\Tests\Unit;

use PHPUnit\Framework\TestCase;
use huenisys\Publisher\SchemaArticle;

class SchemaArticleTest
    extends TestCase
{
    public function setUp() :void
    {

        // do mockery here

        $rawData = [
            'meta' => 'title: Some Title',
            'body' => '# hello world',
        ];

        // $article = new Article($rawData);

        // dump($article);
    }

    /** @test **/
    public function justSayTrue()
    {
       $this->assertTrue(true);
    }

    /** @test **/
    public function normalizer()
    {
        // here there's no title
        // but we want it as required in an array
        $arr1 = [
            'meta' => [
                'title' => 'hey',
                'author' => 'Paul'
            ],
            'body' => 'body'
        ];


        $result = SchemaArticle::normalizeData($arr1);

        $this->assertTrue(true);
    }
}
