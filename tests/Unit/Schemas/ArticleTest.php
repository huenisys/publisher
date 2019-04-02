<?php

namespace huenisys\Publisher\Tests\Unit\Schemas;

use huenisys\Publisher\Schemas\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest
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
    public function true()
    {
       $this->assertTrue(true);
    }

    /** @test **/
    public function test_normalizer()
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


        $result = Article::normalizeData($arr1);

        $this->assertTrue(true);
    }
}
