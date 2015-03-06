<?php

use App\Article;

class ArticleTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->initDatabase();
    }

    public function tearDown()
    {
        $this->resetDatabase();
    }

    public function testEmptyResult()
    {
        $articles = Article::all();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $articles);
        $this->assertEquals(0, count($articles));
    }

    public function testCreateAndList()
    {
        $articleCount = 10;

        for ($i = 1; $i <= $articleCount; $i ++) {
            Article::create([
                'title' => 'subject ' . $i,
                'body'  => 'body ' . $i,
            ]);
        }

        $articles = Article::all();
        $this->assertEquals($articleCount, count($articles));
    }
}
