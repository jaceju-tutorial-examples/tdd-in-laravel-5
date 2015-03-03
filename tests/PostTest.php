<?php

use App\Post;

class PostTest extends TestCase
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
        $posts = Post::all();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $posts);
        $this->assertEquals(0, count($posts));
    }

    public function testCreateAndList()
    {
        $postCount = 10;

        for ($i = 1; $i <= $postCount; $i ++) {
            Post::create([
                'title' => 'subject ' . $i,
                'body'  => 'body ' . $i,
            ]);
        }

        $posts = Post::all();
        $this->assertEquals($postCount, count($posts));
    }
}
