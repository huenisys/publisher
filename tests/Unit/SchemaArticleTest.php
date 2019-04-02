<?php

namespace huenisys\Publisher\Tests\Unit;

use PHPUnit\Framework\TestCase;
use huenisys\Publisher\Schema\Article;

class ArticleTest
    extends TestCase
{
    /** @test **/
    public function normalizeData_receivedArrayHasUppercasedFirstKeys()
    {
        // here there's no title
        // but we want it as required in an array
        $data = [
            'meta' => [
                'title' => 'hey1',
            ],
            'body' => 'body'
        ];

        $this->assertArrayHasKey('Title', Article::normalizeData($data));
        $this->assertArrayHasKey('Body', Article::normalizeData($data));
    }

    /** @test **/
    public function normalizeData_metaGetsFlattened()
    {
        // here there's no title
        // but we want it as required in an array
        $data = [
            'meta' => [
                'title1' => 'hey',
                'author1' => 'Paul',
            ],
            'body1' => 'body'
        ];

        $this->assertEquals([
            'Title1' => 'hey',
            'Author1' => 'Paul',
            'Body1' => 'body'
        ], Article::normalizeData($data));
    }
}
